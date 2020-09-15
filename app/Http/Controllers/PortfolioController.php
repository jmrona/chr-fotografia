<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use App\Portfolio;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return Portfolio::orderBy('sort', 'ASC')->get();
        }else{
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'img' => 'required'
        ]);

        $title = strtolower(str_replace(' ', '', $request->title));

        if($request->img){
            //Directory
            $dir = public_path('img'.DIRECTORY_SEPARATOR.$title);

            //Name img
            $name = strtolower($title).'_'.time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];
            $name_thumbnail = 'thumbnail_'.strtolower($title).'_'.time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];

            //Path
            $path = $dir.DIRECTORY_SEPARATOR.$name;
            $path_thumbnail = $dir.DIRECTORY_SEPARATOR.$name_thumbnail;


            if(! \File::isDirectory($dir)){
                \File::makeDirectory($dir, 493, true);
            }else{
                return[
                    'error' => 'This portfolio already exist'
                ];
            }

            \Image::make($request->img)->resize(1280,720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            \Image::make($request->img)->resize(354,200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path_thumbnail, 60);
            $request->merge(['img' => $name]);
            $request->merge(['img_thumbnail' => $name_thumbnail]);
        }

        $portFolio = new Portfolio;
        $portFolio->title = $request->title;
        $portFolio->url = 'img'.DIRECTORY_SEPARATOR.$title.DIRECTORY_SEPARATOR;
        $portFolio->img = $request->img;
        $portFolio->thumbnail = $request->img_thumbnail;
        $portFolio->visibility = $request->AlbumVisibility;
        $portFolio->sort = $request->sort;
        $portFolio->save();

        return $portFolio;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $portFolio = Portfolio::findOrFail($request->id);

        $oldDirectory = strtolower(str_replace(' ', '', $portFolio->title));
        $oldImg = $portFolio->img;
        $oldThumbnail = $portFolio->thumbnail;

        $title = strtolower(str_replace(' ', '', $request->title));

        if($request->img && $request->img != $oldImg){
            //Directory
            $newDir = public_path('img'.DIRECTORY_SEPARATOR.$title);
            $oldDir = public_path('img'.DIRECTORY_SEPARATOR.$oldDirectory);

            //Elimino la antigua foto
            unlink(public_path($portFolio->url.$oldImg));
            unlink(public_path($portFolio->url.$oldThumbnail));

            // Cambio de nombre al directorio
            rename($oldDir, $newDir);

            //Name img
            $name = $title.'_'.time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];
            $name_thumbnail = 'thumbnail_'.$title.'_'.time().'.' . explode('/', explode(':', substr($request->img, 0, strpos($request->img, ';')))[1])[1];

            //Path
            $path = $newDir.DIRECTORY_SEPARATOR.$name;
            $path_thumbnail = $newDir.DIRECTORY_SEPARATOR.$name_thumbnail;

            \Image::make($request->img)->resize(1280,720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            \Image::make($request->img)->resize(354,200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path_thumbnail, 60);

            $request->merge(['img' => $name]);
            $request->merge(['thumbnail' => $name_thumbnail]);

            $portFolio->title = $request->title;
            $portFolio->img = $request->img;
            $portFolio->thumbnail = $request->thumbnail;
            $portFolio->url = 'img'.DIRECTORY_SEPARATOR.$title.DIRECTORY_SEPARATOR;
            $portFolio->visibility = $request->visibility;
            $portFolio->sort = $request->sort;

            $portFolio->save();
        }

        if($request->img == $oldImg){

            //Rename file
            $oldName = explode('_', $oldImg);
            $oldName[0] = $title;
            $newName = implode('_',$oldName);
            $fileUpdated = 'img\\'.$oldDirectory.'\\'.$newName;

            rename($portFolio->url.$portFolio->img, $fileUpdated);

            //Rename directory
            $newDir = public_path('img'.DIRECTORY_SEPARATOR.$title);
            $oldDir = public_path('img'.DIRECTORY_SEPARATOR.$oldDirectory);

            rename($oldDir, $newDir);

            $portFolio->title = $request->title;
            $portFolio->img = $newName;
            $portFolio->url = 'img'.DIRECTORY_SEPARATOR.$title.DIRECTORY_SEPARATOR;
            $portFolio->visibility = $request->visibility;
            $portFolio->sort = $request->sort;
            $portFolio->save();
        }

        return $portFolio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portFolio = Portfolio::findOrFail($id);

        //Delete directory
        \File::deleteDirectory(public_path($portFolio->url));

        $portFolio->delete();
    }
}
