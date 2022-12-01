<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResources;

//baseböl öröklünk it is használhatjuk a metodusait
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
        return $this->sendResponse(new Blogresources($blog), "Post Létrejött");

    }

    //jön ez id ide, lekérjük a modeltöl és beleteszi a változoba,
    //megnézzük hogy van e tartalma, ha nincs akkor hibamessage
    //elküldjük
    public function show($id){
        $blog= Blog::find($id);
        //php fügvény, ha nem sikerült az átvétel
        if(is_null($blog)){
            return $this->sendError("Post nem létezik");
        }

        return $this->sendResponse(new Blogresources( $blog ), "Post betöltve");
    }

    public function update(Request $request, $id){
        $input = $request->all();
        
        $validator = Validator::make($input,[
            "title" => "required",
            "description" => "required"
        ]);
        //beépitett üzenetet küld, ha nikerült
        if($validator->fails() ){
            return $this->sendError($validator->errors() );
        }
        //ha minden renben van, $blog-ban van a tartalom
        $blog= Blog::find($id);
        $blog->update($request->all());
        
        //visszajelzést küldünk
        return $this->sendResponse( new BlogResources($blog), "Post frissitve");
    }

    public function destroy(Blog $id){
        // $blog= Blog::find($id);
        // $blog->delete();
        Blog::destroy($id);
        //kell az üres tömb, mert 2 parmétert vár
        return $this->sendResponse([],"Post törölve");
    }

}
