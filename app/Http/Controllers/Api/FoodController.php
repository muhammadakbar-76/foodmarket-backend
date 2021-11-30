<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function all(Request $request){
        $id = $request->id;
        $limit = $request->input("limit", 6); //bedanya dgn dynamic props, kita bisa nentuin default value
        $name = $request->name;
        $types = $request->types;

        $price_from = $request->price_from;
        $price_to = $request->price_to;

        $rate_from = $request->rate_from;
        $rate_to = $request->rate_to;

        if ($id) {
           $food = Food::find($id);

            if ($food) {
                return ResponseFormatter::success(
                    $food,
                    "Product Data has been successfully fetched"
                );
            }

            return ResponseFormatter::error(
                null,
                "Product not found",
                404
            );
        }

        $food = Food::query();

        if ($name) {
            $food->where("name","like","%".$name."%");
        }

        if ($types) {
            $food->where("types","like","%".$types."%");
        }
        
        if ($price_from) {
            $food->where("price",">=",$price_from);
        }

        if ($price_to) {
            $food->where("price","<=",$price_to);
        }

        if ($rate_from) {
            $food->where("rate",">=",$rate_from);
        }
        if ($rate_to) {
            $food->where("rate",">=",$rate_to);
        }

        return ResponseFormatter::success(
            $food->paginate($limit), //gak pake get()?
            "Product Data has been successfully fetched"
        );
    }
}
