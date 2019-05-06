<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
use App\User as PageModel;
use App\User;
use App\Models\City;
use App\Models\Stick;
use App\Models\Board;
use App\Models\Interest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use View;
use File;

class UsersController extends BaseController{
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

    public function detail($username){
        $record=PageModel::where('username',$username)->firstOrFail();
        $sticks=Stick::filterForUser($username);
        return view('users/detail',compact('record','sticks'));
    }

    public function edit($id){
        $record=PageModel::where('id',$id)->firstOrFail();
        return view($this->pageUrl.'.edit',compact('record'));
    }

    public function update(Request $request, $id){
        $record=PageModel::find($id);
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        $record->save();
        return redirect()->back();
    }

    public function update_photo(Request $request, $id){
        $record=PageModel::where('id',$id)->firstOrFail();

        if($request->hasFile('image_url')){
            $imageField=$this->imageFields[0];
            parent::handleImageUpload(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('image_url'),
                $imageField['name'],
                $imageField['width'],
                $imageField['height']
                );
            $record->save();
            return redirect()->back();
        }

    }

    public function update_main_image(Request $request, $id){
        $record=PageModel::where('id',$id)->firstOrFail();
        if($request->hasFile('main_image')){
            $imageField=$this->imageFields[1];
            parent::handleImageUpload(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('main_image'),
                $imageField['name'],
                $imageField['width'],
                $imageField['height']
            );
            $record->save();
            return redirect()->back();
        }
    }

    public function follow( $following){

        auth()->user()->follow($following);
        return redirect()->back();
    }

    public function unfollow( $following){

        auth()->user()->unfollow($following);
        return redirect()->back();
    }

    public function create_stick($id){
        $user=User::find($id);
        $parent=$user;
        $boards=$user->boards()->get();
        $cities=City::all();

        return view('sticks.create',compact('boards','cities','parent',$this->pageUrl));
    }

    public function store_stick(Request $request,$id){

        $user=PageModel::find($id);
        $record=new Stick();
        if($record::$dateFields){
            foreach($record::$dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }
        if($request->hasFile('image_path')){

            $imageField=$record::$imageFields[0];
            parent::handleImageUploadNoResize(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('image_path'),
                $imageField['name']
            );

        }

        $user->publishStick(
            $stick=new Stick(request(['name','content','before_price','sale_price','city_id','district_id']))
            ,$record->image_path,$record->begin_date,$record->end_date
        );

        $board=$user->boards()->where('id', $request->board_id)->firstOrFail();
        if($board!=null){
            $board->sticks()->save($stick);
        }
        else{
            $board_new=new Board;
            $board_new->name=$request->board_id;
            $user->boards()->save($board_new);
            $board_new->sticks()->save($stick);
        }
        return redirect()->route($this->pageUrl.'.detail',['username'=>$user->username]);
    }

    public function create_board($id){
        $interests=Interest::all();
        return view('boards.create',compact('interests','id'));
    }

    public function store_board(Request $request, $id){
        $user=PageModel::find($id);

        $user->publishBoard(
            $board=new Board(request(['name','description']))
        );

        foreach ($request->interests as $interest){
            $the_interest=Interest::find($interest);

            if($the_interest!=null){
                $the_interest->boards()->attach($board);

            }
        }
        return redirect()->route($this->pageUrl.'.detail',['username'=>$user->username]);
    }

    public function sticks_detail( Stick $stick){
        return view('sticks.detail',compact('stick'));
    }

    public function boards_index($username){
        $record=User::where('username',$username)->firstOrFail();
        $boards=$record->boards()->get();
        return view('users.boards_index',compact('boards','record'));
    }
}
