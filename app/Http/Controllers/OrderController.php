<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\myUser;
use App\Models\Option;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'user_id' => 'required|exists:my_users,id',
            'products' => 'required|array',
            'pick_up_date' => 'required|string',
            'payment_type' => 'required|string',
            'total' => 'required|numeric',
            'additionalInstructions' => 'nullable|string',
        ]);

        $now = now()->setTimezone('America/Mexico_City');
        $pickUpDate = Carbon::createFromFormat('d/m/Y g:i:s A', $request['pick_up_date'], 'America/Mexico_City');

        // Horarios de las categorías
        $CATEGORY_TIMES = [
            'Desayunos' => [
                'start' => Carbon::parse('08:00 AM', 'America/Mexico_City'),
                'end' => Carbon::parse('01:00 PM', 'America/Mexico_City'),
                'days' => [Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY], // Solo de lunes a viernes
                'error_message' => 'Los pedidos para desayunos solo se aceptan de lunes a viernes.'
            ],
            'Comida Corrida' => [
                'start' => Carbon::parse('01:00 PM', 'America/Mexico_City'),
                'end' => Carbon::parse('05:30 PM', 'America/Mexico_City'),
                'days' => [Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY], // Solo de lunes a viernes
                'error_message' => 'Los pedidos para comida corrida solo se aceptan de lunes a viernes.'
            ],
            'Todo el day' => [
                'start' => Carbon::parse('08:00 AM', 'America/Mexico_City'),
                'end' => Carbon::parse('05:30 PM', 'America/Mexico_City'),
                'days' => [Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY, Carbon::SATURDAY], // Lunes a sábado
                'error_message' => 'Los pedidos para comida todo el día solo se aceptan de lunes a sábado.'
            ],
        ];



        // Validación: Verificar si el usuario está baneado
        $user = myUser::findOrFail($request->user_id);
        if ($user->is_banned) {
            return response()->json(['error' => 'El usuario está baneado y no puede realizar pedidos.'], 403);
        }

        if (!$user->verified_at) {
            return response()->json(['error' => 'Debes de verificarte antes de poder hacer pedidos.'], 404);
        }

        // Validación: Verificar la disponibilidad de los productos
        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);

            if (!$product || !$product->available) {
                return response()->json([
                    'error' => "El producto '{$productData['name']}' no está disponible en este momento."
                ], 422);
            }

            $category = Category::find($product->category_id);
            if (!$category) {
                return response()->json([
                    'error' => "La categoría del producto '{$product->name}' no existe."
                ], 422);
            }

            $categoryName = $category->name;

            // Validar la hora según la categoría
            if (isset($CATEGORY_TIMES[$categoryName])) {
                $startTime = Carbon::createFromFormat('g:i A', $category->availability_start, 'America/Mexico_City');
                $endTime = Carbon::createFromFormat('g:i A', $category->availability_end, 'America/Mexico_City');

                // Asegurarnos de que `pick_up_date` también esté en el mismo día para la comparación
                $startTime->setDate($pickUpDate->year, $pickUpDate->month, $pickUpDate->day);
                $endTime->setDate($pickUpDate->year, $pickUpDate->month, $pickUpDate->day);

                if (!$pickUpDate->between($startTime, $endTime)) {
                    return response()->json([
                        'error' => "El producto '{$product->name}' de la categoría '{$categoryName}' solo está disponible entre {$startTime->format('g:i A')} y {$endTime->format('g:i A')}."
                    ], 422);
                }

                // Validación: Verificar si el día de la semana es válido según la categoría
                $allowedDays = $CATEGORY_TIMES[$categoryName]['days'];


                if (!in_array($pickUpDate->dayOfWeek, $allowedDays)) {
                    $errorMessage = $CATEGORY_TIMES[$categoryName]['error_message'];
                    return response()->json([
                        'error' => $errorMessage
                    ], 422);
                }

            } else {
                return response()->json([
                    'error' => "No se ha configurado un horario para la categoría '{$categoryName}'."
                ], 422);
            }
        }

        // Validación 1: La fecha y hora de recogida no pueden ser en el pasado
        if ($pickUpDate->lessThanOrEqualTo($now)) {
            return response()->json(['error' => 'La fecha y hora de recogida no pueden ser en el pasado.'], 422);
        }

        // Validación 2: No se aceptan pedidos los domingos
        if ($pickUpDate->isSunday()) {
            return response()->json(['error' => 'No se aceptan pedidos los domingos.'], 422);
        }

        // Validación 3: La hora de recogida no puede ser mayor a las 7 PM
        if ($pickUpDate->hour >= 19) {
            return response()->json(['error' => 'La hora de recogida no puede ser después de las 7:00 PM.'], 422);
        }

        // Validación 4: Los pedidos deben realizarse con al menos 30 minutos de anticipación
        if ($pickUpDate->lessThanOrEqualTo($now->addMinutes(30))) {
            return response()->json(['error' => 'Debes realizar tu pedido con al menos 30 minutos de anticipación.'], 422);
        }

        // Validación 5: No se aceptan transferencias los viernes, sábados ni domingos
        if ($request['payment_type'] === 'transferencia' &&
            ($pickUpDate->isFriday() || $pickUpDate->isSaturday() || $pickUpDate->isSunday())) {
            return response()->json(['error' => 'No se aceptan transferencias los viernes, sábados.'], 422);
        }


        // Iniciar una transacción para asegurar que los datos sean consistentes
        DB::beginTransaction();

        try {
            // Crear el pedido
            $order = Order::create([
                'user_id' => $request->user_id,
                'pick_up_date' => $request->pick_up_date,
                'payment_type' => $request->payment_type,
                'total' => $request->total,
                'message' => $request->additionalInstructions,
                'hash' => 'temp'
            ]);

            // Generar el hash basado en el ID del pedido y actualizarlo
            $order->hash = hash('sha256', $order->id);
            $order->save();

            // Guardar los productos del pedido
            foreach ($request->products as $productData) {
                // Encontrar el producto por su ID
                $product = Product::findOrFail($productData['id']);

                // Crear la relación con la tabla intermedia (OrderProduct)
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $productData['totalPrice'],
                    'selected_options' => json_encode($productData['selectedOptions']),
                    'image_url' => $productData['image_url'],
                    'product_name' => $productData['name']

                ]);
            }

            // Confirmar la transacción
            DB::commit();

            $adminTokens = myUser::whereIn('role', ['ADMIN', 'AXULIAR'])
                ->whereNotNull('push_token')
                ->pluck('push_token')
                ->toArray();

            // Enviar notificación
            $this->sendPushNotification(
                $adminTokens,
                'Nuevo pedido creado',
                "Hora de entrega: $request->pick_up_date",
                ['order_id' => $order->id]
            );

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order,
            ], 201);

        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            return response()->json([
                'error' => 'An error occurred while processing the order',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function index(Request $request)
    {
        $userId = $request->input('user_id'); // Obtener el ID del usuario del request

        // Buscar el rol del usuario desde la base de datos
        $user = myUser::find($userId);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($user->role === 'ADMIN' || $user->role === 'AUXILIAR') {
            // Si el usuario es admin o auxiliar, incluye información del usuario relacionado con el pedido
            $orders = Order::with('user:id,name,lastname,phone')->get();
        } else {
            // Si el usuario es cliente, solo devuelve sus propias órdenes
            $orders = Order::with('user:id,name,lastname,phone')
                ->where('user_id', $userId)
                ->get();
        }

        return response()->json($orders);
    }
    public function toggleFavorite($id)
    {
        try {
            // Buscar la orden por su ID
            $order = Order::findOrFail($id);

            // Cambiar el estado de "is_fav" (true a false o viceversa)
            $order->is_fav = !$order->is_fav;
            $order->save();

            return response()->json([
                'message' => 'Order favorite status updated successfully.',
                'order' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update favorite status.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function togglePaid(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Cambiar el estado de `paid`
        $order->paid = !$order->paid;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado de pago actualizado',
            'order' => $order,
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        // Obtener el pedido con sus productos
        $order = Order::with(['products'])->find($request->order_id);

        // Formatear los productos con las opciones seleccionadas y sus precios
        $productsWithOptions = $order->products->map(function ($product) {
            // Decodificar las opciones seleccionadas
            $selectedOptions = json_decode(json_decode($product->pivot->selected_options, true), true);

            // Obtener las opciones disponibles del producto
            $options = Option::where('product_id', $product->id)->get();

            // Calcular los precios de las opciones seleccionadas
            $selectedOptionPrices = [];
            foreach ($selectedOptions as $key => $value) {
                $option = $options->firstWhere('name', $key);
                if ($option && isset($option->values) && isset($option->prices)) {
                    $index = array_search($value, $option->values); // Buscar el índice del valor seleccionado
                    if ($index !== false && isset($option->prices[$index])) {
                        $selectedOptionPrices[] = $option->prices[$index];
                    }
                }
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image_url' => $product->image_url,
                'selectedOptions' => $selectedOptions,
                'quantity' => $product->pivot->quantity,
                'selectedOptionPrices' => $selectedOptionPrices,
            ];
        });

        return response()->json([
            'products' => $productsWithOptions,
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        // Validar el estado recibido
        $validated = $request->validate([
            'status' => 'required|string|in:preparando,listo,entregado,cancelado',
            'message' => 'nullable|string|max:255',
        ]);

        // Buscar el pedido
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        // Actualizar el estado
        $order->status = $validated['status'];

        // Si el estado es "Cancelado", guardar el mensaje opcional
        if ($validated['status'] === 'cancelado') {
            $order->cancelation_msg = $validated['message'] ?? null;
        }

        $order->save();

        // Obtener el token del cliente
        $clientToken = myUser::where('id', $order->user_id)->value('push_token');

        if ($clientToken) {
            // Enviar notificación al cliente
            $this->sendPushNotification(
                [$clientToken],
                'Estado de tu pedido actualizado',
                "Tu pedido ahora está: {$order->status}.",
                ['order_id' => $order->id, 'status' => $order->status]
            );
        }

        return response()->json([
            'message' => 'Estado del pedido actualizado correctamente',
            'order' => $order
        ]);
    }



    private function sendPushNotification($tokens, $title, $body, $data = [])
    {
        $client = new Client();

        $notifications = [];
        foreach ($tokens as $token) {
            $notifications[] = [
                'to' => $token,
                'sound' => 'default',
                'title' => $title,
                'body' => $body,
                'data' => $data,
            ];
        }

        try {
            $response = $client->post('https://exp.host/--/api/v2/push/send', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($notifications),
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Manejar errores
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

}
