<?php

namespace App\Http\Controllers;
use App\Models\myUser;
use Twilio\Rest\Client;

use Illuminate\Http\Request;

class sendSmsVerification extends Controller
{
    public function sendsms(Request $request) {

        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $senderNumber = env('TWILIO_PHONE');
        $verifyServiceSid = env('TWILIO_VERIFY_SERVICE_SID');

        $twilio = new Client($sid, $token);

        // Envía un SMS de verificación utilizando el servicio Twilio Verify
        $verification = $twilio->verify->v2
            ->services($verifyServiceSid)
            ->verifications
            ->create($senderNumber, "sms");

        return response()->json([
            'message' => 'Código de verificación enviado al número ' . $request->phone,
        ]);
    }

    public function checkVerification(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'code' => 'required|numeric'
        ]);

        $recieverNumber = "+52" . $request->phone;

        $myPhoneNumber = env('TWILIO_PHONE');
        $verifyServiceSid = env('TWILIO_VERIFY_SERVICE_SID');
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');

        $twilio = new Client($sid, $token);

        $verificationCheck = $twilio->verify->v2
            ->services($verifyServiceSid)
            ->verificationChecks
            ->create([
                'to' => $myPhoneNumber,
                'code' => $request->code
            ]);

        if ($verificationCheck->status === 'approved') {

            $user = myUser::where('phone', $request->phone)->first();

            if ($user) {
                $user->update(['verified_at' => now()]);

                return response()->json([
                    'message' => 'Verificación exitosa!',
                    'verified_number' => $request->phone
                ]);
            } else {
                return response()->json([
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Código incorrecto.'
            ], 400);
        }
    }

    public function sendDummySms(Request $request) {
        $verificationCode = rand(100000, 999999); // Código de verificación de 6 dígitos

        // Guardamos el código en la sesión o base de datos (puedes usar una base de datos para simular la verificación real)
        session(['verification_code' => $verificationCode, 'phone' => $request->phone]);

        return response()->json([
            'message' => 'Código de verificación simulado enviado al número ' . $request->phone,
            'verification_code' => $verificationCode // Solo para pruebas, no lo devuelvas en producción
        ]);
    }

    public function verifyDummySms(Request $request) {

        $request->validate([
            'phone' => 'required|digits:10',
            'code' => 'required'
        ]);

        if ($request->code == 123456) {

            $user = myUser::where('phone', $request->phone)->first();

            if ($user) {
                $user->update(['verified_at' => now()]);

                return response()->json([
                    'message' => 'Verificación exitosa!',
                    'verified_number' => $request->phone
                ]);
            } else {
                return response()->json([
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Código incorrecto o sesión expirada.'
            ], 400);
        }
    }
}
