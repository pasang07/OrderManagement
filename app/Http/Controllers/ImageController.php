<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Null_;

class ImageController extends Controller
{
    public  function saveGallery($file,$folder_name,$width, $height)
    {
        $filenamewithextension =$file->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $file->getClientOriginalExtension();
        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$file->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }

    public  function saveAnyImg(Request $request,$folder_name,$imageName,$width,$height)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function saveOrgImg(Request $request,$folder_name,$imageName)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }

    public  function saveImg(Request $request,$folder_name,$imageName)
    {
        $filenamewithextension = $request->file('image')->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file('image')->getClientOriginalExtension();

        //filename to store
        $filenametostore = $filename.'_'.time().'.'.$extension;

        //Upload File
        $image=$request->file('image')->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function saveBannerImg(Request $request,$folder_name,$imageName,$width,$height)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = $folder_name.'_'.time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }

    public  function saveSEOImg(Request $request,$folder_name,$imageName,$width,$height)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = $folder_name.'_'.time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }

    public  function saveAnyFile(Request $request,$folder_name,$imageName)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();
        //filename to store
        $filenametostore = uniqid().time().'.'.$extension;
        //Upload File
        $file=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);

        //File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function saveOrgGallery($file,$folder_name)
    {
        $filenamewithextension =$file->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $file->getClientOriginalExtension();
        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$file->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname());
//        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }


    public function deleteImg($folder_name,$file_name)
    {
        File::delete(public_path('uploads/'.$folder_name.'/'.$file_name));
        File::delete(public_path('uploads/'.$folder_name.'/thumbnail/'.$file_name));
    }

    public function deleteFile($folder_name,$file_name)
    {
        File::delete(public_path('uploads/'.$folder_name.'/'.$file_name));
    }
     public function deleteVideo($folder_name)
    {
        File::deleteDirectory(public_path('uploads/'.$folder_name));
    }
}
