<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AfiliadosController extends Controller
{
    public function index(){
    	return view('admin.afiliados.index');
    }

    public function indexPorcentajesComisiones(){
    	return view('admin.afiliados.porcentajes_comisiones.index');
    }
}
