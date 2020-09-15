<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Portfolio;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index(Request $request, $id)
    {
        if($request->ajax()){
            $gallery = DB::table('gallery')
                ->join('portfolios', 'gallery.portfolioId', '=', 'portfolios.id')
                ->where('portfolios.id',$id)
                ->select('gallery.*', 'portfolios.url', 'portfolios.title')
                ->orderBy('sort','ASC')
                ->get();

                // foreach (json_decode($gallery) as $key => $value){
                //     $gallery[$key]['path'] = 1;
                //     // $gallery[$key]['path'] = $gallery[$key]['url'].$gallery[$key]['img'];
                // }

            return $gallery;
        }else{
            return view('welcome');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'img' => 'required'
        ]);
        $portFolio = Portfolio::findOrFail($request->portfolioId);

        if($request->img && $portFolio->url){
            //Directory
            $dir = public_path($portFolio->url);

            //Name img
            $name = time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];
            $name_thumbnail = 'thumbnail_'.time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];

            //Path
            $path = $dir.DIRECTORY_SEPARATOR.$name;
            $path_thumbnail = $dir.DIRECTORY_SEPARATOR.$name_thumbnail;


            if(! \File::isDirectory($dir)){
                return[
                    'error' => 'This portfolio doesn\'t exist'
                ];
            }

            //Size of original picture
            if($request->width && $request->height){
                $witdh = $request->width;
                $height = $request->height;

                \Image::make($request->img)->resize($witdh,$height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
            }else{
                \Image::make($request->img)->resize(1280,720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
            }

            \Image::make($request->img)->resize(354,200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path_thumbnail, 40);
            $request->merge(['img' => $name]);
            $request->merge(['thumbnail' => $name_thumbnail]);
        }

        $gallery = new Gallery;
        $gallery->img = $request->img;
        $gallery->thumbnail = $request->thumbnail;
        $gallery->position = $request->position;
        $gallery->width = $request->width;
        $gallery->height = $request->height;
        $gallery->ratio = $request->ratio;
        $gallery->visibility = $request->visibility;
        $gallery->sort = $request->sort;
        $gallery->portfolioId = $request->portfolioId;
        $gallery->save();

        return $gallery;
    }

    public function update(Request $request)
    {
        $image = Gallery::findOrFail($request->id);

        $image->position = $request->position;
        $image->ratio = $request->ratio;
        $image->visibility = $request->visibility;
        $image->sort = $request->sort;
        $image->save();
        return $image;
    }

    public function destroy($img_id, $portFolio_id)
    {
        $portFolio_url = Portfolio::where('id', $portFolio_id)->get('url');
        $image = Gallery::findOrFail($img_id);

        $url = $portFolio_url[0]['url'].$image['img'];
        $thumbnail = $portFolio_url[0]['url'].$image['thumbnail'];

        //Delete directory
        unlink(public_path($url));
        unlink(public_path($thumbnail));

        $image->delete();
    }
}
