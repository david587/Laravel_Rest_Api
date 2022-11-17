<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResources;

//baseböl öröklünk it is
class BlogController extends BaseController
{
    public function index() {
        //összes adat
        $blogs =Blog::all();
        //baseböl meghivjuk, 
        return $this->sendResponse(BlogResources::collection( $blogs ), "OK");
    }

    //adattáblába kiirja az adatot
    public function store(Request $request) {
        //adat megérkezik itt
        $input = $request->all();

        //üres mezőt nem akarunk elfogadni, gyártunk
        $validator = Validator::make( $input,[
            "title" => "required",
            "description" => "required"
        ]);

        //ha sikertelen
        if( $validator->fails()){
            return $this->sendError( $validator->errors());
        }

        //ha nem üres a mező
        $blog =Blog::create( $input );
        //amit beirtunk eltárolja
        return $this->sendResponse(new BlogResurce($blog), "Post Létrejött");

    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }

}
