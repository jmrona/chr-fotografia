<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AboutMe;

class AboutMeController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            return AboutMe::where('id', 1)->get();
        }else{
            return view('welcome');
        }
    }

    public function update(Request $request)
    {
        $aboutMe = AboutMe::find(1);
        $aboutMe->title = $request->title;
        $aboutMe->subtitle = $request->subtitle;
        $aboutMe->description = $request->description;
        $aboutMe->save();

        return $aboutMe;
    }

}
