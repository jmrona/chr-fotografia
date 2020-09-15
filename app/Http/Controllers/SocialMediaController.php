<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialMedia;

class SocialMediaController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return SocialMedia::all();
        }else{
            return view('welcome');
        }
    }

    public function update(Request $request)
    {
        $datos = $request->icons;

        foreach($datos as $key => $value){
            SocialMedia::where('name',$value['name'])
                        ->update(['url' => $value['url']]);
        }

        return SocialMedia::all();
    }
}
