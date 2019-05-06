<?php
namespace App\Http\Controllers\Board;
use App\Http\Controllers\BaseController;
use App\Models\Board as PageModel;
use App\Models\Interest;
use View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BoardsController extends BaseController{
    public function __construct(PageModel $model)
    {

        $this->middleware('auth');
        $this->pageUrl='boards';
        $this->pageName = 'Boardlar';
        $this->pageItem = 'Board';
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

    public function index(){
        return view('includes.board');
    }

    public function create(){
        $interests=Interest::all();
        return view('boards.create',compact('interests'));
    }

    public function store(Request $request){
        //$this->validate($request, PageModel::$rules,PageModel::messages());
        $record = new PageModel;

        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }

        Auth::user()->boards()->save($record);

        foreach ($request->interests as $interest){
            $the_interest=Interest::find($interest);

            if($the_interest!=null){
                $the_interest->boards()->save($record);
                $record->boards()->attach($the_interest);

            }
            else{
                $interest_new=new Interest();
                $interest_new->name=$interest;
                $interest_new->save();
                $record->interests()->attach($interest_new);
            }
        }




        session()->flash('success', 'Yeni '.$this->pageItem.' oluşturuldu.');
        return redirect()->route('users.index',Auth::user()->username);
    }
}
