<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'productName'=>['required','string'],
            'quantity'=>['required'],
            'price' => ['required']
        ]);

        $name = $request->productName;
        $quantity = $request->quantity;  
        $price = $request->price;
        $time = date('Y-m-d H:i:s');
        $totalPrice = $quantity * $price;

        if ($name && $quantity && $price && $time && $totalPrice) {

            $reply = array("status"=>1,"pname"=>$name,"quantity"=>$quantity,"price"=>$price,"time"=>$time,"total"=>$totalPrice);

        }else {

            $reply = array("status"=>0,"message"=>'Sorry an error occured. Kindly try again');

        }
           

        echo json_encode($reply);         

    }
}
