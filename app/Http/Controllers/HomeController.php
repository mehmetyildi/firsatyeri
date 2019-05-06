<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:58
 */
namespace App\Http\Controllers;
use App\User as PageModel;

use View;

use App\Models\Stick;

class HomeController extends Controller{

    public function __construct(PageModel $model)
    {
        $this->middleware('auth');
        $this->pageUrl='users';
        $this->pageName = 'Kullanıcılar';
        $this->pageItem = 'Kullanıcı';
        $this->model = $model;
        $this->fields = $model::$fields;
        $this->imageFields = $model::$imageFields;
        $this->docFields = $model::$docFields;
        $this->dateFields = $model::$dateFields;
        $this->urlFields = $model::$urlFields;
        $this->booleanFields = $model::$booleanFields;
        View::share(array(
            'pageUrl' => $this->pageUrl,
            'pageName' => $this->pageName,
            'pageItem' => $this->pageItem,
        ));
    }

    public function home(){
        $sticks=Stick::
        orderBy('created_at','desc')->get();
        return view('home', compact('sticks'));
    }
}
