<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

//igy örökölhetjük a BaseContorller metodusát
class AuthController extends BaseController
{
    public function signIn(Request $request){
        //token gyártása,azonositásra
        //jön egy bejelentkezési probálkozás
        if( Auth::attempt(["email"=> $request->email,"password" => $request->password])){
            //hitelességet ellenörzi a 2adatnak
            $authUser = Auth::user();
            //ha sikeres,generálunk egy tokent,megadjuk a nevét,szöveges formátumba kerül a token(plaintext)
            $success[ "token" ] = $authUser->createToken("MyAuthApp")->plainTextToken;
            $success["name"] = $authUser->name;
            //addig kell tárolni a tokent amig ki nem jelentkezik

            //basecontrollerből hivjuk ezt
            return $this->sendResponse($success,"Sikeres bejelentkezés");
        }
        //ha nem sikerül a bejelentkezés
        else{
            //$error,$errormessage
            return $this->sendError("Unathorized.".["error" => "Hibás adatok" ]);
        }
    }

    public function signUp(Request $request){
        //gyártunk egy felhasználót(adataival eggyüt) 
        $validator = Validator::make( $request->all(), [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "confirm_password" =>"required|same:password"
        ]);
        //a validáló nemsikerült
        if($validator->fails){
            return sendError("Error Validation", $validator->errors() );
        }

        //ha minden oke fut tovább a program
        $input = $request->all();
        //titkositva küldjük be az adatbázisba
        $input["password"] = bcript( $input["password"] );
        //ide átadunk mindent
        $user = User::create($input);
        //üzenetek
        // BaseControllerben a result=$success
        $success["name"] = $user->name;

        return sendResponse( $success, "Sikeres regisztráció");
    }
}
