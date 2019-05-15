<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\BaseController;
use App\Models\Group;
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
            parent::handleUserImageUpload(
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
            parent::handleUserImageUpload(
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

        return view('users.create_stick',compact('boards','cities','parent'));
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
        $board=$user->boards()->find($request->board_id);
        if($board!=null){
            $board->sticks()->save($stick);
        }
        else{

            $board_new=new Board;
            $board_new->name=$request->board_id;

            $user->boards()->save($board_new);
            $board_new->sticks()->save($stick);
        }
        return redirect()->route('users.detail',['username'=>$user->username]);
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

    public function sticks_detail(PageModel $record, Stick $stick ){
        $boards=$record->boards()->get();
        $owned_groups=$record->ownedGroups()->get();
        $admin_of=$record->isAdminOf();
        $groups=$owned_groups->toBase()->merge($admin_of);
        return view('sticks.detail',compact('stick','record','boards','groups'));
    }

    public function boards_index($username){
        $record=User::where('username',$username)->firstOrFail();
        $boards=$record->boards()->get();
        return view('users.boards_index',compact('boards','record'));
    }

    public function boards_detail($id, Board $board){
        $record=User::find($id);
        $sticks=Stick::filterForBoard($board);
        return view('users.boards_detail', compact('record','sticks','board') );
    }

    public function move_stick_to_board(User $user, Stick $stick, Request $request){

       $new_board=Board::find($request->board_id);
       $stick->board_id=$new_board->id;
       $stick->save();
       session()->flash('success', 'Stick sizin '.$new_board->name.' boardunuza taşındı');
       return redirect()->back();
    }

    public function move_stick_to_group(User $user, Stick $stick,Request $request){
        $new_board=Board::find($request->board_id);
        $group=Group::find($request->group_id);
        if(!$new_board->saved_sticks()->get()->contains($stick)){
            $new_board->saved_sticks()->attach($stick);

        }
        $stick->save();
        session()->flash('success', 'Stick '.$group->name.'adlı grubun '.$new_board->name.' boarduna kaydedildi');
        return redirect()->back();
    }

    public function save_stick(Request $request,User $user, Stick $stick){
        $board=Board::find($request->board_id);
        if(!$board->saved_sticks()->get()->contains($stick)){
            $board->saved_sticks()->attach($stick);

        }
        session()->flash('success', 'Stick sizin '.$board->name.' boardunuza kaydedildi');
        return redirect()->back();
    }

    public function interests(User $user){
        $interests=Interest::all();
        return view('users.interests',compact('user','interests'));
    }

    public function interests_store(Request $request, User $user){
        $user->interests()->sync($request->interests);
        return redirect()->route('users.edit',['id'=>$user->id]);
    }

    public function interests_edit(User $user){
        $interests=Interest::all();
        return view('users.interests_edit',compact('interests','user'));
    }

    public function interests_update(Request $request, User $user){
        $user->interests()->sync($request->interests);
        return redirect()->route('users.edit',['id'=>$user->id]);
    }

    public function edit_board(User $record, Board $board){
        $interests=Interest::all();
        return view('boards.edit',compact('interests','board','record'));
    }

    public function update_board(Request $request, User $record, Board $board){

        $board->name=$request->name;
        $board->description=$request->description;
        $board->save();
        $board->interests()->sync($request->interests);
        foreach ($board->sticks as $stick){
            $stick->interests()->sync($board->interests()->get());
        }
        return redirect()->route($this->pageUrl.'.board.detail',['id'=>$record->id,'board'=>$board->id]);
    }

}
