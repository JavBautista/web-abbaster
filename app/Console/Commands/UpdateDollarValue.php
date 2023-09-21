<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\DollarPriceCurrent; // Asegúrate de importar el modelo correcto

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

            // Registrar un mensaje de éxito en el registro de Laravel
            $this->info('Valor del dólar actualizado correctamente: ' . $exchangeRate);
        } catch (\Exception $e) {
            // En caso de error en la solicitud, registrar un mensaje de error
            $this->error('No se pudo actualizar el valor del dólar.');
        }
    }
}
