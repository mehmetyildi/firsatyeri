<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:58
 */
namespace App\Http\Controllers;
use App\Models\Interest;
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
        if(count(auth()->user()->interests()->get())==0) {
            return redirect()->route('users.interests', ['user' => auth()->user()->id]);
        }
        $record=auth()->user();
        $sticks=Stick::filterForHome($record);

        return view('home', compact('sticks','record'));
    }
}
