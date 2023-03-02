<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        if(!$request->ajax())
            return view('admin.cedis.warehouse.index', ['warehouses'=>$warehouses]);
        else
            return $warehouses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cedis.warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
                'name'=>'required',
            ],
            [
                'name.required'=>'Por favor, ingrese un nombre.',
        ]);

        $warehouse = new Warehouse;
        $warehouse->name = $request->name;
        $warehouse->active = 1;
        $warehouse->save();

        Session::flash('alert', 'Almacen agregado correctamente');
        Session::flash('alert-class', 'alert-success');
        return redirect("/admin/cedis/warehouse");
    }

    public function getWarehouse($warehouse_id){
        //if(!$request->ajax()) return redirect('/');
        $warehouse = Warehouse::findOrFail($warehouse_id);
        return $warehouse;
    }

    public function updateActivar(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $warehouse = Warehouse::findOrFail($request->id);
        $warehouse->active = 1;
        $warehouse->save();

    }

    public function updateDesactivar(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $warehouse = Warehouse::findOrFail($request->id);
        $warehouse->active = 0;
        $warehouse->save();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function imageWarehouse($warehouse_id){
        $warehouse = Warehouse::find($warehouse_id);
        return view('admin.cedis.warehouse.image',['warehouse'=>$warehouse]);
    }

    public function uploadImage(Request $request){
        $warehouse_id = $request->input('warehouse_id');
        $image = $request->file('image');
        $warehouse = Warehouse::find($warehouse_id);

        $warehouse->image = $image->store('warehouses','public');
        $warehouse->save();

        Session::flash('alert', 'Imagen guardada exitosamente.');
        Session::flash('alert-class', 'alert-success');
        return redirect("/admin/cedis/warehouse/image/$warehouse_id");
    }

    public function deleteImage(Request $request){
        $warehouse_id = $request->input('warehouse_id');
        $warehouse = Warehouse::find($warehouse_id);
        $file = $warehouse->image;
        $exists = Storage::disk('public')->exists($file);
        $warehouse->image  = NULL;
        $warehouse->save();
        if($exists){
            Storage::disk('public')->delete($file);
            Session::flash('alert', 'La imagen fue eliminada exitosamente.');
            Session::flash('alert-class', 'alert-success');
            return redirect("/admin/cedis/warehouse/image/$warehouse_id");
        }
        Session::flash('alert', 'No se pudo borrar el archivo del servidor, intentelo nuevamente.');
        Session::flash('alert-class', 'alert-danger');
        return redirect("/admin/cedis/warehouse/image/$warehouse_id");
    }


}
