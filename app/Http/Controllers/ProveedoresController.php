<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\Shop;
use App\Http\Requests\CreateProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shop_id)
    {
        $shop=Shop::find($shop_id);
        $proveedores = Proveedor::where('shop_id',$shop_id)->paginate(10);
        return view('admin.proveedores.index',[
            'shop'=>$shop,
            'proveedores'=>$proveedores
        ]);
    }

    public function view($shop_id,$proveedor_id){
        $shop=Shop::find($shop_id);
        $proveedor=Proveedor::find($proveedor_id);
        
        return view('admin.proveedores.view',[
            'shop'=>$shop,
            'proveedor'=>$proveedor,        

        ]);   
    }

    public function add($shop_id){
        $shop=Shop::find($shop_id);
        return view('admin.proveedores.add',[
            'shop'=>$shop,  
        ]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProveedorRequest $request)
    {
        $image = $request->file('image');
        $proveedor = Proveedor::create([
            'shop_id'=>$request->input('shop_id'),
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'status'=>$request->input('status'),
            'phone'=>$request->input('phone'),
            'address'=>$request->input('address'),
            'email'=>$request->input('email'),
            'commentary'=>$request->input('commentary'),
            'image'=> $image->store('proveedores','public'),
            //'image'=>'https://lorempixel.com/600/338/?'.mt_rand(0,1000),
            
        ]);
        $shop_id=$request->input('shop_id');
        return redirect("/dashboard/store/$shop_id/proveedores");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($shop_id,$proveedor_id)
    {
        $shop=Shop::find($shop_id);
        $proveedor=Proveedor::find($proveedor_id);
        
        return view('admin.proveedores.edit',[
            'proveedor'=>$proveedor,          
            'shop'=>$shop,          
        ]);   
    
    }

    public function editStatus($shop_id,$proveedor_id)
    {
        $shop=Shop::find($shop_id);
        $proveedor=Proveedor::find($proveedor_id);
        return view('admin.proveedores.edit_status',[
            'proveedor'=>$proveedor, 
            'shop'=>$shop,          
        ]);                  
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProveedorRequest $request)
    {
        $proveedor = Proveedor::find($request->input('proveedor_id'));
        $proveedor->name = $request->input('name');
        $proveedor->description = $request->input('description');
        $proveedor->status = $request->input('status');
        $proveedor->phone = $request->input('phone');
        $proveedor->address = $request->input('address');
        $proveedor->email = $request->input('email');
        $proveedor->commentary = $request->input('commentary');     
        $proveedor->save();
        return redirect("/dashboard/store/$proveedor->shop_id/proveedores");
    }

    public function updateStatus(Request $request){
        $proveedor = Proveedor::find($request->input('proveedor_id'));
        $proveedor->status = $request->input('status');
        $proveedor->save();
        return redirect("/dashboard/store/".$proveedor->shop_id."/proveedores");    
    }

    public function remove($shop_id,$proveedor_id){
        $shop=Shop::find($shop_id);
        $proveedor=Proveedor::find($proveedor_id);
        
        return view('admin.proveedores.remove',[
            'proveedor'=>$proveedor, 
            'shop'=>$shop,          
        ]);             
    }

   public function delete(Request $request){
        $proveedor = Proveedor::find($request->input('proveedor_id'));
        $shop_id=$proveedor->shop_id;
        $proveedor->delete();
        return redirect("/dashboard/store/".$shop_id."/proveedores");    
    }
}
