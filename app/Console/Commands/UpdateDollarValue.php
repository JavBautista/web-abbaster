<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\DollarPriceCurrent;
use App\Product;
use Carbon\Carbon;

class UpdateDollarValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dollar-value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el valor del dólar en la base de datos';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Realizar una solicitud a la API de Open Exchange Rates para obtener el valor actual del dólar
        $apiKey = env('OPENEXCHANGERATES_API_KEY');
        $baseCurrency = 'USD'; // Moneda base que deseas consultar
        $targetCurrency = 'MXN'; // Moneda objetivo

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->get("https://openexchangerates.org/api/latest.json?app_id={$apiKey}&base={$baseCurrency}");
            $data = json_decode($response->getBody(), true);

            // Obtén el valor del dólar en la moneda objetivo
            $exchangeRate = $data['rates'][$targetCurrency];

            // Guardar el valor del dólar en la base de datos
            $dollar = DollarPriceCurrent::findOrFail(1);
            $dollar->price = $exchangeRate;
            $dollar->save();

            $dollar_price= $dollar->price;
            //$products = Product::all();
            // Obtener todos los productos con costo en dólares válido
            $products = Product::whereNotNull('cost_dollar')->get();

            $products_actualizados=0;
            foreach($products as $product){
                $new_retail = $product->cost_dollar * $dollar_price;
                $product->retail = $new_retail;
                $product->save();
                $products_actualizados++;
            }

            // Obtén la fecha y hora actual
            $currentDateTime = Carbon::now()->toDateTimeString();

            // Registrar un mensaje de éxito en el registro de Laravel
            $message = "Valor del dólar actualizado correctamente a {$exchangeRate} en {$currentDateTime}. Productos actualizados {$products_actualizados}";
            $this->info($message);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // En caso de error en la solicitud HTTP, registrar un mensaje de error
            $this->error('Error al hacer la solicitud HTTP: ' . $e->getMessage());
        } catch (\Exception $e) {
            // En caso de otros errores, registrar un mensaje de error general
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
