<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:58
 */
namespace App\Http\Controllers;



use App\Models\Stick;

class HomeController extends Controller{
    public function home(){
        $sticks=Stick::
        orderBy('created_at','desc')->get();
        return view('home', compact('sticks'));
    }
}
