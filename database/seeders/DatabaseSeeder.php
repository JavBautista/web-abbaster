<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Shop::class)->create([
            'name'=>'Eagletek MX',
        ]); 
        factory(App\Shop::class)->create([
            'name'=>'ZiotRobotic',
        ]);     

        
        factory(App\Proveedor::class)->times(1)->create();

        //factory(App\Category::class)->create(['name'=>'Camaras','description'=>'Camaras','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'Cámaras de vigilancia','description'=>'Cámaras de vigilancia','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'GPS rastreadores','description'=>'GPS rastreadores','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'Chapas eléctricas','description'=>'Chapas eléctricas','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'Smarthome - Domótica','description'=>'Smarthome - Domótica','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'TAGs RFID NFC','description'=>'TAGs RFID NFC','status'=>0,'root'=>0,'shop_id'=>1]);
factory(App\Category::class)->create(['name'=>'Accesorios','description'=>'Accesorios','status'=>0,'root'=>0,'shop_id'=>1]);

factory(App\Category::class)->create(['name'=>'Accesorios','description'=>'Accesorios','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Audio','description'=>'Audio','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Cables y conectores','description'=>'Cables y conectores','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Comunicación e interfaces','description'=>'Comunicación e interfaces','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Domótica','description'=>'Domótica','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Electromecánica','description'=>'Electromecánica','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Impresora 3D','description'=>'Impresora 3D','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Integrado','description'=>'Integrado','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Kit proyectos DIY','description'=>'Kit proyectos DIY','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Mecánica','description'=>'Mecánica','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Motores','description'=>'Motores','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Optoelectrónica','description'=>'Optoelectrónica','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Pantallas','description'=>'Pantallas','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Pasivos','description'=>'Pasivos','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Potencia y Energía','description'=>'Potencia y Energía','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Prototipado','description'=>'Prototipado','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Robótica','description'=>'Robótica','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Sensores','description'=>'Sensores','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Servicios','description'=>'Servicios','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'TAGs RFID NFC','description'=>'TAGs RFID NFC','status'=>0,'root'=>0,'shop_id'=>2]);
factory(App\Category::class)->create(['name'=>'Tarjeta de desarrollo','description'=>'Tarjeta de desarrollo','status'=>0,'root'=>0,'shop_id'=>2]);



        /*      
        factory (App\Product::class)->times(40)->create();
        */
        
        
         // La creación de datos de roles debe ejecutarse primero
	    $this->call(RoleTableSeeder::class);
	    // Los usuarios necesitarán los roles previamente generados
	    $this->call(UserTableSeeder::class);
    }
}
