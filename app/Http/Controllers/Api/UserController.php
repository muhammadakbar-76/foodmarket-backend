<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
{
    use PasswordValidationRules;
   public function login(Request $request){
       try {
           $request->validate([
               "email" => "email:dns|required",
               "password" => "required"
           ]);

           $credentials = request(["email","password"]);

           if(!Auth::attempt($credentials)){
               return ResponseFormatter::error([
                   "message" => "unauthorized",
               ],"Login Failed", 500);
           }

           $user = User::where("email", $request->email)->first();

           if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception("Invalid Credentials");
           }

           $tokenResult = $user->createToken("authToken")->plainTextToken;

           return ResponseFormatter::success([
               "access_token" => $tokenResult,
               "token_type" => "Bearer",
               "user" => $user
           ], "Authenticated");

       } catch (Exception $error) {
           return ResponseFormatter::error([
               "message" => "Something went wrong",
               "error" => $error
           ], "Authentication Failed", 500);
       }
   }

   public function register(Request $request){
       try {
           $request->validate([
               "name" => "required|string|max:255",
               "email" => "required|string|email:dns|max:255|unique:users",
               "password" => $this->passwordRules()
           ]);

           User::create([
               "name" => $request->name,
               "email" => $request->email,
               "address" => $request->address,
               "houseNumber" => $request->houseNumber,
               "phoneNumber" => $request->phoneNumber,
               "city" => $request->city,
               "password" => Hash::make($request->password),
           ]);

           $user = User::where("email",$request->email)->first();

           $tokenResult = $user->createToken("authToken")->plainTextToken;

           return ResponseFormatter::success([
               "access_token" => $tokenResult,
               "token_type" => "Bearer",
               "user" => $user
           ]);

       } catch (Exception $error) {
           return ResponseFormatter::error([
               "message" => "Something went wrong",
               "error" => $error
           ],"Authentication Failed", 500);
       }
   }

   public function logout(Request $request){
       $token = $request->user()->currentAccessToken()->delete();

       return ResponseFormatter::success($token,"Token Revoked");
   }

   public function updateProfile(Request $request){
       $data = $request->all();

    try {
        $user = Auth::user(); //Auth biasanya buat backend, auth() untuk front karena gk perlu namespace
       
        User::where("id", $user->id)->update($data);

        return ResponseFormatter::success($user, "Profile Updated");
    } catch (Exception $error) {
        return ResponseFormatter::error([
            "message" => "Something went wrong",
            "error" => $error
        ],"Update Failed", 500);
    }
   }

   public function fetch(Request $request){
       return ResponseFormatter::success($request->user(),"Data user berhasil diambil");
   }

   public function updatePhoto(Request $request){
       $validator = FacadesValidator::make($request->all(), [
        "file" => "required|image|max:2048"
       ]);

       if ($validator->fails()) {
           return ResponseFormatter::error([
               "error" => $validator->errors()
           ],"update photo fails", 401);
       }

       if($request->file("file")){
           $file = $request->file->store("assets/user", "public");
       }

       $user = Auth::user();
    //    $user->profile_photo_path = $file;
    //    $user->update(); //katanya sih gk pp error karena gk terdeteksi sama vscode, tapi gk enak diliat
       User::where("id",$user->id)->update("profile_photo_path", $file);

       return ResponseFormatter::success([$file], "file successfully updated");
   }
}
