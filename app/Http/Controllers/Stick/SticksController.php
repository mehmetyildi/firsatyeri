<?php
namespace App\Http\Controllers\Stick;
use App\Models\Comment;
use App\Models\Stick as PageModel;
use App\Models\City;
use App\Models\District;
use App\Models\Board;
use App\Models\Stick;
use View;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SticksController extends BaseController{

    public function __construct(PageModel $model)
    {
        $this->middleware('auth');
        $this->pageUrl='sticks';
        $this->pageName = 'Stickler';
        $this->pageItem = 'Stick';
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

    public function create(){
        $boards=Auth::user()->boards()->get();
        $cities=City::all();

        return view('sticks.create',compact('boards','cities'));
    }

    public function store(Request $request){
        //$this->validate($request, PageModel::$rules,PageModel::messages());
        $record = new PageModel;

        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        /** Date Inputs **/
        if($this->dateFields){
            foreach($this->dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }

        /** Image Inputs **/
        if($request->hasFile('image_path')){

            $imageField=$this->imageFields[0];
            parent::handleImageUploadNoResize(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('image_path'),
                $imageField['name']
            );

        }
        $record->user_id=Auth::user()->id;

        $board=Auth::user()->boards()->find($record->board_id);
        if($board!=null){
            $board->sticks()->save($record);
            $record->boards()->attach($board);

        }
        else{
            $board_new=new Board;
            $board_new->name=$request->board_id;
            Auth::user()->boards()->save($board_new);
            $board_new->sticks()->save($record);
        }


        session()->flash('success', 'Yeni '.$this->pageItem.' oluşturuldu.');
        return redirect()->route('users.index',Auth::user()->username);
    }

    public function create_comment(Request $request, Stick $stick){

        Auth::user()->publishComment(
            $comment=new Comment(request(['content'])),$stick->id
        );
        return redirect()->back();
    }
}
