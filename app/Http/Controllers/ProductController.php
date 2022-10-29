<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function listProduct(Request $request)
    {
        $search = $request->input("search");
        //  $price = $request->input("price");
        // $products = Product::all();

        // $products = Product::where(function($q) {
        //     $q->where("price",2000)->orwhere("stock",">",0);
        //})->where("name", "Cireng")

        //orwhere("price",$price)
        // ->whereIn("name",["cireng", "cimol"])
        //Select * from products where price=2000 or stock>0 and name="cireng"
        //->where("stock",">",0);
        // ->get();
        $products = Product::where("name","LIKE","%".$search."%")
            ->paginate();
        return response()->json($products);
    }

    public function detailProduct($product_id)
    {
       // $result = Product::find($product_id);
       $result = Product::findOrFail($product_id);

        //$result = Product::where("name","LIKE","%".$product_id."%")->first();
        //$result = Product::where("name","LIKE","%".$product_id."%")->firstOrFail();

        return response()->json($result);
    }

   // public function deleteProduct($product_id)
  //  {
  //      $products = ["Cireng", "Basreng", "Cimol"];
  //      array_splice($products,$product_id,1);

   //     return response()->json($products);
   // }

    public function saveProduct(Request $request)

    {   

       $request->validate([
        "name"=> "required|string",
        "stock"=> "requred|integer",
        "price"=> "required|integer",
       ]);
 //dd($request->input());      
       $result = Product::where("price",">",0)->update([
            "name" => $request->input("name"),
            "stock" => $request->input("stock"),
            "price" => $request->input("price"),
       ]);

       

     //  $result = new Product();
  //     $result->name = $request->name;
    //  $result->stock = $request->stock;
     //  $result->price = $request->price;
      // $result->save();

     //  $result = Product::create([
      //     "name"=>$request->name,
     //      "stock" =>$request->stock,
      //     "price" =>$request->price,
     //  ]);

        // $result = new Product();

        // $result->name = "Basreng";
        // $result->stock = 5;
        // $result->price = 5000;
        // $result->save();

        return response()->json($result);
    }

    public function deleteProduct($product_id = null)

    {
       // $result = Product::findOrFail($product_id);
      //  $result->delete();

        $result = Product::where("price","<", 5000)->delete();

        $result->delete();

        return response()->json($result);
    }

}