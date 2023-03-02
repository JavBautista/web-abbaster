<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ProductQuestionsAnswers;
use App\ProductQuestions;
use App\Category;
use App\Product;
use App\Shop;

class ProductQuestionsController extends Controller
{
    public function index($shop_id){
        $shop=Shop::find($shop_id);

        $categories=Category::where('shop_id',$shop_id)->get();

        $questions=[];
        foreach ($categories as $category) {
            foreach($category->products as $product){
                foreach($product->questions as $question){
                    if(!$question->status)
                        $questions[]=$question;
                }
            }
        }

        return view('admin.preguntas.index',[
            'shop'=>$shop,
            'questions'=>$questions,

        ]);
    }

    public function indexQuestions(Request $request){
        return view('admin.preguntas.index_questions');
    }

    public function getQuestions(Request $request){
        $questions = ProductQuestions::with('product')
        ->where('status',0)->get();
        return $questions;
    }

    public function storeAnswer(Request $request){
        ProductQuestionsAnswers::create([
            'product_questions_id'=>$request->question_id,
            'answer'=>$request->answer,
        ]);

        $question=ProductQuestions::find($request->question_id);
        $question->status=1;
        $question->save();
    }

    public function deleteQuestionNew(Request $request){
       $question=ProductQuestions::find($request->id);
       $question->delete();
    }

    public function store(Request $request){

    	$this->validate($request,[
                'question'=>['required'],
            ],
            [
                'question.required'=>'Ingrese pregunta.',
        ]);

    	$product = Product::find($request->input('product_id'));
    	$question = ProductQuestions::create([
            'product_id'=> $request->input('product_id'),
            'question'=> $request->input('question'),
            'status'=> 0,
        ]);

        return redirect("/".$request->input('tienda')."/producto/".$product->slug);

    }

    public function addAnswer(Request $request){
        /*$this->validate($request,[
                'answer'=>['required'],
            ],
            [
                'answer.required'=>'Ingrese respuesta.',
        ]);*/
        ProductQuestionsAnswers::create([
            'product_questions_id'=>$request->input('question_id'),
            'answer'=>$request->input('answer'),
        ]);

        $question=ProductQuestions::find($request->input('question_id'));
        $shop_id = $question->product->category->shop_id;

        $question->status=1;
        $question->save();

        Session::flash('alert', 'Respuesta guardada satisfactoriamente!');
        Session::flash('alert-class', 'alert-success');

        return redirect("/dashboard/store/$shop_id/preguntas");

    }

    public function deleteQuestion($id){
       $question=ProductQuestions::find($id);
       $shop_id = $question->product->category->shop_id;
       $question->delete();
       Session::flash('alert', 'Respuesta eliminada satisfactoriamente!');
       Session::flash('alert-class', 'alert-success');
       return redirect("/dashboard/store/$shop_id/preguntas");
    }
}
