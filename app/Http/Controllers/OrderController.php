<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function saveOrder(Request $r)
    {
        $r->validate([
            "address" => "required|string",
            "orders" => "required|array",
            "orders.*.product_id" => "required|integer",
            "orders.*.quantity" => "required|integer",
        ]);

        $product = [];
        $grandTotal = 0;
        foreach($r->input("orders") as $order) {
            $result = Product::where("stock", ">", $order["quantity"])
            ->findOrfail($order["product_id"]);

            $grandTotal += $result->price * $order["quantity"];
            $product[] = $result;
        }

        $orderData = Order::create([
            "name" => Auth::user()->name,
            "address" => $r->input("address"),
            "total" => $grandTotal,
            "user_id" => Auth::user()->id,
        ]);

        foreach ($product as $key => $item) {
            $quantity = $r->input("orders")[$key]["quantity"];
            OrderDetail::create([
                "name" => $item->name,
                "quantity" => $quantity,
                "price" => $item->price,
                "total" => $item->price * $quantity,
                "order_id" => $orderData->id,
                "product_id" => $item->id,
            ]);
        }

        //201 Status Code : Created
        return response($orderData, 201);
    }
}
