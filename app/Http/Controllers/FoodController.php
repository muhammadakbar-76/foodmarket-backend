<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodRequest;
use App\Http\Requests\FoodUpdateRequest;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food = Food::paginate(10)->withQueryString();
        return view("food.index",[
            "food" => $food
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("food.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        $data = $request->all();

        $data["picturePath"] = $request->file("picturePath")->store("assets/food","public");

        Food::create($data);

        return redirect()->route("food.index")->with("success","Food Data has been added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        return view("food.edit", [
            "food" => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(FoodUpdateRequest $request, Food $food)
    {
        $data = $request->all();

        if ($request->file("picturePath")) {
            $data["picturePath"] = $request->file("picturePath")->store("assets/food","public");
        }

        $food->update($data);

        return redirect()->route("food.index")->with("success", "Food Data has been edited successfully");
    }

    /**
     * Remove the specified resource from storage.
    *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        if ($food->picturePath) {
            Storage::delete("public".$food->picturePath);
        }

        $food->delete();

        return redirect()->route("food.index")->with("success","Food Data has been deleted successfully");
    }
}
