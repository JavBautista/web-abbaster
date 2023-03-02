<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerCourse;

class CustomerCourseController extends Controller
{
    public function store(Request $request){
        $shop_id     = $request->shop_id;
        $sale_id     = $request->sale_id;
        $customer_id = $request->customer_id;
        $course_id   = $request->course_id;

        $customer_course = new CustomerCourse;
        $customer_course->customer_id = $customer_id;
        $customer_course->course_id = $course_id;
        $customer_course->save();

        return redirect()->route('dashboard.store.sales.view',['shop_id'=>$shop_id,'sale_id'=>$sale_id ])
                ->with('success','Asignación exitosa!');

    }
}
