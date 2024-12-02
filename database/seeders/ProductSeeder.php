<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $comidaCorrida = Category::where('name', 'Comida Corrida')->first();
        $comidaTodoDia = Category::where('name', 'Todo el day')->first();
        $desayunos = Category::where('name', 'Desayunos')->first();
        $menus = Category::where('name', 'Menus')->first();
        $combos = Category::where('name', 'Combos')->first();

        $Cocktail_De_Frutas =  Product::create([
            'name' => 'Cocktail de frutas',
            'description' => 'Frutas: Melón, Plátano, Manzana, Papaya. Con Yogurt y Granola',
            'price' => 38.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://peopleenespanol.com/thmb/nKNCbtZACj0CWsvOSBEdfu4LDHM=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/coctel-de-frutas-facil-2000-7dd72cf51d2d4c9d8e876b85255111e6.jpg'
        ]);

        Option::create([
            'name' => 'Tamaño',
            'values' => ['Chico (1/2 litro)', 'Grande (litro)'],
            'prices' => [0, 10.00],
            'product_id' => $Cocktail_De_Frutas->id,
        ]);

        $hotCakes = Product::create([
            'name' => 'Hot Cakes',
            'description' => 'Deliciosos hot cakes, con un adereso',
            'price' => 14.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://karo.com.mx/wp-content/uploads/2023/09/Hotcakes-de-trigo-y-frutos-rojos.jpg',
        ]);
        Option::create([
            'name' => 'Cantidad de piezas',
            'values' => ['1 piezas', '3 piezas'],
            'prices' => [0.00, 21.00],
            'product_id' => $hotCakes->id,
        ]);
        Option::create([
            'name' => 'Acompañante',
            'values' => ['Mermelada de fresa', 'Lechera','Cajeta'],
            'product_id' => $hotCakes->id,
        ]);

        $huevos_al_gusto = Product::create([
            'name' => 'Huevos al gusto',
            'description' => 'Deliciosos huevos al gusto: A la mexicana, con jamón, salchicha o champiñón',
            'price' => 38.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://d2j6dbq0eux0bg.cloudfront.net/images/50348138/2234774859.jpg',
        ]);
        Option::create([
            'name' => 'Preparación',
            'values' => ['A la mexicana', 'Jamón','Salchicha','Champiñón'],
            'product_id' => $huevos_al_gusto->id,
        ]);

        $picadas_sencillas = Product::create([
            'name' => 'Picadas sencillas',
            'description' => 'Picadas sencillas (salsa y queso)',
            'price' => 13.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://i.blogs.es/ff849b/picadas-veracruzanas/1366_2000.jpg',
        ]);
        Option::create([
            'name' => 'Cantidad de Piezas',
            'values' => ['1 piezas', '3 piezas'],
            'prices' => [0, 22.00],
            'product_id' => $picadas_sencillas->id,
        ]);
        Option::create([
            'name' => 'Salsas',
            'values' => ['Tomate', 'Ranchera','Verde'],
            'product_id' => $picadas_sencillas->id,
        ]);


        $picadas_preparadas = Product::create([
            'name' => 'Picadas preparadas',
            'description' => 'Picadas preparadas con un topping a elección.',
            'price' => 35.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://tb-static.uber.com/prod/image-proc/processed_images/38cdd7fe692007f523a5ebdcc5c0aa7d/fb86662148be855d931b37d6c1e5fcbe.jpeg',
        ]);
        Option::create([
            'name' => 'Cantidad de Piezas',
            'values' => ['1 piezas', '3 piezas'],
            'prices' => [0, 30.00],
            'product_id' => $picadas_preparadas->id,
        ]);
        Option::create([
            'name' => 'Topping',
            'values' => ['Huevo', 'Pibil','Adobo','Chicharrón'],
            'prices' => [0, 0, 0, 0],
            'product_id' => $picadas_preparadas->id,
        ]);

        $empanadas = Product::create([
            'name' => 'Empanadas',
            'description' => 'Empanadas con relleno, salsa y crema y queso fresco al gusto',
            'price' => 15.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://img-global.cpcdn.com/recipes/55fc011003923aeb/1200x630cq70/photo.jpg',
        ]);
        Option::create([
            'name' => 'Relleno',
            'values' => ['Queso de hebra', 'Pollo', 'Picadillo'],
            'prices' => [0, 0, 0],
            'product_id' => $empanadas->id,
        ]);
        Option::create([
            'name' => 'Al gusto',
            'values' => ['Crema', 'Queso Fresco'],
            'prices' => [0, 0],
            'product_id' => $empanadas->id,
        ]);
        Option::create([
            'name' => 'Salsa',
            'values' => ['Verde', 'Tomate', 'Ranchera'],
            'prices' => [0, 0, 0],
            'product_id' => $empanadas->id,
        ]);

        $quesadillas_de_maiz_sencilla = Product::create([
            'name' => 'Quesadilla de maíz sencilla',
            'description' => 'Quesadilla con salsa a el gusto',
            'price' => 15.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://www.mimaseca.com/media/1396/tacos_chicharron.jpg',
        ]);
        Option::create([
            'name' => 'Tamaño',
            'values' => ['Chica', 'Grande'],
            'prices' => [0, 15.00],
            'product_id' => $quesadillas_de_maiz_sencilla->id,
        ]);
        Option::create([
            'name' => 'Salsa',
            'values' => ['Verde', 'Tomate', 'Ranchera'],
            'prices' => [0, 0, 0],
            'product_id' => $quesadillas_de_maiz_sencilla->id,
        ]);

        $quesadilla_de_maiz_preparada = Product::create([
            'name' => 'Quesadilla de maíz preparada',
            'description' => 'Quesadilla con salsa a el gusto',
            'price' => 25.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBPOZxp6zMP9Tdi7ln8x2nNmvBGInDALZFrQ&s',
        ]);
        Option::create([
            'name' => 'Tamaño',
            'values' => ['Chica', 'Grande'],
            'prices' => [0, 17.00],
            'product_id' => $quesadilla_de_maiz_preparada->id,
        ]);
        Option::create([
            'name' => 'Salsa',
            'values' => ['Verde', 'Tomate', 'Ranchera'],
            'prices' => [0, 0,0],
            'product_id' => $quesadilla_de_maiz_preparada->id,
        ]);
        Option::create([
            'name' => 'Relleno',
            'values' => ['Pibil', 'Adobo'],
            'prices' => [0, 0],
            'product_id' => $quesadilla_de_maiz_preparada->id,
        ]);

        $enfrijoladas = Product::create([
            'name' => 'Enfrijoladas',
            'description' => 'Enfrijoladas con creama y queso',
            'price' => 60.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://img-global.cpcdn.com/recipes/cebc1de0686aebdc/400x400cq70/photo.jpg',
        ]);
        Option::create([
            'name' => 'Relleno',
            'values' => ['Pollo', 'Queso de hebra','Huevo'],
            'prices' => [0, 0, 0],
            'product_id' => $enfrijoladas->id,
        ]);

        $entomatadas = Product::create([
            'name' => 'Entomatadas',
            'description' => 'Entomatadas con crema y queso',
            'price' => 60.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://assets.unileversolutions.com/recipes-v2/214593.jpg',
        ]);
        Option::create([
            'name' => 'Relleno',
            'values' => ['Pollo', 'Queso de hebra','Huevo'],
            'prices' => [0, 0, 0],
            'product_id' => $entomatadas->id,
        ]);

        $Tostadas = Product::create([
            'name' => 'Tostadas',
            'description' => 'Entomatadas con crema y queso',
            'price' => 60.00,
            'category_id' => $desayunos->id,
            'image_url' => 'https://guerrerotortillas.com/wp-content/uploads/2021/04/beef-tostadas.jpg',
        ]);
        Option::create([
            'name' => 'Relleno',
            'values' => ['Pollo', 'Queso de hebra','Huevo'],
            'prices' => [0, 0, 0],
            'product_id' => $Tostadas->id,
        ]);


        $Bistec_al_gusto = Product::create([
            'name' => 'Bistec',
            'description' => 'Bistec al gusto con guarnición',
            'price' => 50.00,
            'category_id' => $comidaCorrida->id,
            'image_url' => 'https://thumbs.dreamstime.com/b/mexican-stake-bistec-la-mexicana-94492950.jpg',
        ]);
        Option::create([
            'name' => 'Guarnición',
            'values' => ['Arroz', 'Arroz, ensalada y tortillas'],
            'prices' => [0, 10.00],
            'product_id' => $Bistec_al_gusto->id,
        ]);
        Option::create([
            'name' => 'Preparación',
            'values' => ['A la mexicana', 'Empanizado', 'Asado'],
            'prices' => [0, 0, 0],
            'product_id' => $Bistec_al_gusto->id,
        ]);

        $pechuga = Product::create([
            'name' => 'Pechuga',
            'description' => 'Pechuga asada o empanizada con guarnición a elección.',
            'price' => 50.00,
            'category_id' => $comidaCorrida->id,
            'image_url' => 'https://storage.googleapis.com/fitia_public_images/recipes%2FGR-R-V-00001677_jja6xc2viof62dz8fg3bir4c_large.jpg',
        ]);
        Option::create([
            'name' => 'Guarnición',
            'values' => ['Arroz', 'Arroz, ensalada y tortillas'],
            'prices' => [0, 10.00],
            'product_id' => $pechuga->id,
        ]);
        Option::create([
            'name' => 'Preparación',
            'values' => ['Empanizada', 'Asada'],
            'prices' => [0, 0, 0],
            'product_id' => $pechuga->id,
        ]);

        $ensalada = Product::create([
            'name' => 'Ensalada',
            'description' => 'Elegir 2 proteinas y 3 complementos. +Aderezo Ranch y crotones',
            'price' => 65.00,
            'category_id' => $comidaCorrida->id,
            'image_url' => 'https://industriasantaclara.co/wp-content/uploads/2021/05/img-ensalada.jpg',
        ]);
        Option::create([
            'name' => 'Proteina 1',
            'values' => ['Pollo','Jamón','Salchicha','Manchego','Queso fresco','Atún'],
            'prices' => [0,0,0,0,0,0],
            'product_id' => $ensalada->id,
        ]);
        Option::create([
            'name' => 'Proteina 2',
            'values' => ['Pollo','Jamón','Salchicha','Manchego','Queso fresco','Atún'],
            'prices' => [0,0,0,0,0,0],
            'product_id' => $ensalada->id,
        ]);
        Option::create([
            'name' => 'Complemento 1',
            'values' => ['Jícama','Pepino','Zanahoria','Arándanos','Nueces','Almendra','Jitomate','Elote'],
            'prices' => [0,0,0,0,0,0,0,0],
            'product_id' => $ensalada->id,
        ]);
        Option::create([
            'name' => 'Complemento 2',
            'values' => ['Jícama','Pepino','Zanahoria','Arándanos','Nueces','Almendra','Jitomate','Elote'],
            'prices' => [0,0,0,0,0,0,0,0],
            'product_id' => $ensalada->id,
        ]);
        Option::create([
            'name' => 'Complemento 3',
            'values' => ['Jícama','Pepino','Zanahoria','Arándanos','Nueces','Almendra','Jitomate','Elote'],
            'prices' => [0,0,0,0,0,0,0,0],
            'product_id' => $ensalada->id,
        ]);

        $chilaquiles = Product::create([
            'name' => 'Chilaquiles',
            'description' => 'Chilaquiles con 1 topping al gusto.',
            'price' => 60.00,
            'category_id' => $comidaCorrida->id,
            'image_url' => 'https://cdn0.recetasgratis.net/es/posts/6/9/0/chilaquiles_rojos_con_pollo_75096_orig.jpg',
        ]);
        Option::create([
            'name' => 'Topping',
            'values' => ['Chicharrón', 'Pollo', 'Picadillo', 'Pibil', 'Adobo', 'Papa'],
            'prices' => [0,0,0,0,0,0],
            'product_id' => $chilaquiles->id,
        ]);

        $cuernito = Product::create([
            'name' => 'Cuernito',
            'description' => 'Lleva lechuga, mayonesa y catsup',
            'price' => 33.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://www.vidactual.com/rcpmaker/wp-content/uploads/2018/10/Cuernito-de-Jam%C3%B3n-y-Queso.jpg',
        ]);
        Option::create([
            'name' => 'Cuerpo',
            'values' => ['Jamón', 'Salchicha','Pollo'],
            'prices' => [0, 0, 5.00],
            'product_id' => $cuernito->id,
        ]);
        Option::create([
            'name' => 'Queso',
            'values' => ['Manchego', 'Fresco','Hebra'],
            'prices' => [0, 0, 0],
            'product_id' => $cuernito->id,
        ]);

        $Baguette = Product::create([
            'name' => 'Baguette',
            'description' => 'Lleva lechuga, mayonesa y catsup',
            'price' => 33.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://sanrafaeldeli.com/wp-content/uploads/2020/06/receta_sandwich_sub.png',
        ]);
        Option::create([
            'name' => 'Cuerpo',
            'values' => ['Jamón', 'Salchicha','Pollo'],
            'prices' => [0, 0, 5.00],
            'product_id' => $Baguette->id,
        ]);
        Option::create([
            'name' => 'Queso',
            'values' => ['Manchego', 'Fresco','Hebra'],
            'prices' => [0, 0, 0],
            'product_id' => $Baguette->id,
        ]);

        $sincronizada = Product::create([
            'name' => 'Sincronizada',
            'description' => 'Lleva queso Manchego, lechuga y jamón',
            'price' => 20.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://www.gastrolabweb.com/u/fotografias/m/2023/12/28/f850x638-56046_133535_5050.jpg',
        ]);
        Option::create([
            'name' => 'Tamaño',
            'values' => ['Chica', 'Grande'],
            'prices' => [0.00, 12.00],
            'product_id' => $sincronizada->id,
        ]);

        $sandwich = Product::create([
            'name' => 'Sandwich',
            'description' => 'Lleva lechuga, mayonesa y catsup',
            'price' => 25.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://editorialtelevisa.brightspotcdn.com/a1/91/54ede86c4a7c89ee98f239261143/sandwich-saludable-para-lunch.jpeg',
        ]);
        Option::create([
            'name' => 'Cuerpo',
            'values' => ['Jamón', 'Salchicha', 'Pollo', 'Atún'],
            'prices' => [0.00, 0.00, 5.00, 5.00],
            'product_id' => $sandwich->id,
        ]);
        Option::create([
            'name' => 'Queso',
            'values' => ['Manchego', 'Fresco','Hebra'],
            'prices' => [0, 0, 0],
            'product_id' => $sandwich->id,
        ]);

        $pambazo = Product::create([
            'name' => 'Pambazo',
            'description' => 'LLeva frijol, queso fresco y mayonesa',
            'price' => 20.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://i.ytimg.com/vi/tKsWIQ2wtl8/sddefault.jpg',
        ]);

        $tacos_de_guisado = Product::create([
            'name' => 'Tacos de guisado',
            'description' => 'Taco de guisado a escoger. Pregunta por los guisados del día!',
            'price' => 19.00,
            'category_id' => $comidaTodoDia->id,
            'image_url' => 'https://images.ctfassets.net/n7hs0hadu6ro/42YF5trfjsN64pJQKoNW8M/04f4aeb7aec6f6cc8a03ec2ec55602b7/un-gustito-con-tacos-de-guisados.jpg',
        ]);
        Option::create([
            'name' => 'Guisados',
            'values' => ['Pibil', 'Adobo','Papa con chorizo','Rajas','Huevo'],
            'prices' => [0, 0, 0, 0, 0],
            'product_id' => $tacos_de_guisado->id,
        ]);

        //Menús
        Product::create([
            'name' => 'Menú 1',
            'description' => 'Adobo con pasta del día, frijoles, agua del día, tortillas y postres del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/xaFlM9r.png'
        ]);

        $menu2 = Product::create([
           'name' => 'Menú 2',
           'description' => 'Pechuga de pollo al gusto con arroz, ensalada, sopa del día, tortillas, postres del día y agua del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/ZLPgMZ6.png'
        ]);
        Option::create([
            'name' => 'Pechuga',
            'values' => ['Empanizada', 'Asada'],
            'prices' => [0, 0],
            'product_id' => $menu2->id,
        ]);

        $menu3 = Product::create([
            'name' => 'Menú 3',
            'description' => 'Bistec al gusto con arroz, sopa del día, frijoles, tortillas, postres del día y agua del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/gaWvPFm.png'
        ]);
        Option::create([
            'name' => 'Bistec',
            'values' => ['A la mexicana', 'Empanizado', 'Asado'],
            'prices' => [0, 0, 0],
            'product_id' => $menu3->id,
        ]);

        $menu4 = Product::create([
            'name' => 'Menú 4',
            'description' => 'Chilaquiles con frijoles, sopa del día, postres del día y agua del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/FRM478Y.png'
        ]);
        Option::create([
            'name' => 'Topping',
            'values' => ['Chicharrón', 'Pollo', 'Picadillo', 'Pibil', 'Adobo', 'Papa'],
            'prices' => [0,0,0,0,0,0],
            'product_id' => $menu4->id,
        ]);

        Product::create([
            'name' => 'Menú 5',
            'description' => 'Rajas con frijoles, sopa del día, postres del día y agua del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/T5CA2yT.png'
        ]);

        Product::create([
            'name' => 'Menú 6',
            'description' => 'Taquitos de pibil (5 tacos) con caldito aparte, postres del día y agua del día.',
            'price' => 74.00,
            'category_id' => $menus->id,
            'image_url' => 'https://i.imgur.com/UGFz42P.png'
        ]);

        //Combos
        Product::create([
            'name' => 'Combo 2',
            'description' => '3 Picadas + Agua del día',
            'price' => 50.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/lxgmR13.png'
        ]);

        Product::create([
            'name' => 'Combo 3',
            'description' => '5 Tacos + Agua del día',
            'price' => 80.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/sIh3VcR.png'
        ]);

        Product::create([
            'name' => 'Combo 4',
            'description' => '3 Hot cakes + jugo de naranja',
            'price' => 50.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/I15z5yZ.png'
        ]);

        Product::create([
            'name' => 'Combo 5',
            'description' => 'Molletes 2 piezas + Agua del día',
            'price' => 38.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/mWBfgqn.png'
        ]);

        $combo6 = Product::create([
            'name' => 'Combo 6',
            'description' => 'Cuernito Jamón o Salchicha + Agua del día',
            'price' => 42.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/9gRiRP4.png'
        ]);

        Option::create([
            'name' => 'Cuernito',
            'values' => ['Jamón', 'Salchicha'],
            'prices' => [0, 0,],
            'product_id' => $combo6->id,
        ]);

        $combo7 = Product::create([
            'name' => 'Combo 7',
            'description' => 'Hot cakes 3 piezas + Licuado de chocomilk o platano 1/2 Litro',
            'price' => 50.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/6jYcaq4.png'
        ]);

        Option::create([
            'name' => 'Licuado',
            'values' => ['Chocomilk', 'Platano'],
            'prices' => [0, 0,],
            'product_id' => $combo7->id,
        ]);

        Product::create([
            'name' => 'Combo 8',
            'description' => '1 Empanada + 1 Picada + Agua del día',
            'price' => 40.00,
            'category_id' => $combos->id,
            'image_url' => 'https://i.imgur.com/3rtD67c.png'
        ]);




    }
}
