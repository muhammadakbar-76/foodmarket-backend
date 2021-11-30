<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10)->withQueryString();
        return view("users.index", [
            "user" => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        
        $data["profile_photo_path"] = $request->file("picturePath")->store("assets/user","public");

        User::create($data);

        return redirect()->route("users.index")->with("success","User Data has been created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("users.edit",[
            "user" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email:dns|max:255|unique:users,email,".$user->id,
            "password" => $this->passwordRules(),
            "address" => "required|string",
            "roles" => "required|string|max:255|in:USER,ADMIN",
            "houseNumber" => "required|string|max:255",
            "phoneNumber" => "required|string|max:255",
            "city" => "required|string|max:255"
        ]);

        $data["password"] = Hash::make($data["password"]);

        if ($request->file("picturePath")) {
            $data["profile_photo_path"] = $request->file("picturePath")->store("assets/user","public");
        }

        $user->update($data);

        return redirect()->route("users.index")->with("success","User Data has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->profile_photo_path) {
            Storage::delete("public".$user->profile_photo_path);
        }
        $user->delete();

        return redirect()->route("users.index")->with("success","User Data has been deleted successfully");
    }
}
