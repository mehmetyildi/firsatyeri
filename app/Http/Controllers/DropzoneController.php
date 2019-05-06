<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Validator;
use Request;
use Response;

class DropzoneController extends Controller {

    public function index() {
        return view('users.image');
    }







    public function upload() {
        if(Input::hasFile('file')) {
            //upload an image to the /img/tmp directory and return the filepath.
            $file = Input::file('file');
            $tmpFilePath = '/img/tmp/';
            $tmpFileName = time() . '-' . $file->getClientOriginalName();
            $file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
            $path = $tmpFilePath . $tmpFileName;
            return response()->json(array('path'=> $path), 200);
        } else {
            return response()->json(false, 200);
        }
    }

}
