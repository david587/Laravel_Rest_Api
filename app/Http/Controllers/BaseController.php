<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message){
        $response = [
            "success" => true,
            "data" => $result,
            "message" => $message
        ];
        //ha minden rendben volt akkor adat és 200as sikeres jelzés
        return response()->json($response, 200);
    }

    //ha nincs rendben
    public function sendError($error, $errorMessage = [], $code= 404){
        $response = [
            "success" => false,
            "message" => $error
        ];

        if(!empty($errorMessage)){
            //ha van tartalma
            $response["data"] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
