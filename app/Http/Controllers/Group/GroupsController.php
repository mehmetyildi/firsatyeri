<?php
namespace App\Http\Controllers\Group;
use App\Models\Group as PageModel;
use App\Models\Group;
use App\Models\Stick;
use App\Models\Wanted;
use View;
use File;
use App\User;
use App\Models\Board;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Interest;
use App\Http\Controllers\BaseController;

class GroupsController extends BaseController{

    public function __construct(PageModel $model)
    {
        $this->middleware('auth');
        $this->pageUrl='groups';
        $this->pageName = 'Gruplar';
        $this->pageItem = 'Grup';
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
        $cities=City::all();
        return view('groups.create',compact('cities'));
    }

    public function store(Request $request){
        //$this->validate($request, PageModel::$rules,PageModel::messages());
        $record = new PageModel;

        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }


        /** Image Inputs **/
        if($request->hasFile('image_path')){

            $imageField=$this->imageFields[0];
            parent::handleGroupImageUpload(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('image_path'),
                $imageField['name']
            );

        }
        $record->user_id=Auth::user()->id;

        $record->save();


        session()->flash('success', 'Yeni '.$this->pageItem.' oluşturuldu.');
        return redirect()->route('groups.detail',$record->id);
    }

    public function index($username){
        $user=User::where('username',$username)->firstOrFail();
        $owned=$user->ownedGroups()->get();
        $group_admin=$user->isAdminOf();
        $following=$user->isMemberOf();
        return view('groups.index',compact('owned','following','group_admin'));
    }

    public function detail($id){
        $record=PageModel::find($id);
        $sticks=Stick::filterForGroup($record);
        $wanteds=$record->wantedAds()->orderBy('created_at','desc')->get();
        return view('groups/detail',compact('record','sticks','wanteds'));
    }

    public function create_stick($id){
        $group=Group::find($id);
        $parent=$group;
        $child="";
        $boards=$group->boards()->get();
        $cities=City::all();

        return view('groups.create_stick',compact('boards','cities','parent','child'));
    }

    public function store_stick(Request $request,$id){

        $group=PageModel::find($id);
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

        $group->publishStick(
            $stick=new Stick(request(['name','content','before_price','sale_price','city_id','district_id']))
            ,$record->image_path,$record->begin_date,$record->end_date
        );
        $stick->user_id=auth()->user()->id;
        $board=$group->boards()->find($request->board_id);
        if($board!=null){

            $board->sticks()->save($stick);
            $stick->interests()->sync($board->interests()->get());
        }
        else{
            $board_new=new Board;
            $board_new->name=$request->board_id;
            $group->boards()->save($board_new);
            $board_new->sticks()->save($stick);
        }
        return redirect()->route($this->pageUrl.'.detail',['id'=>$id]);
    }

    public function create_board($id){
        $interests=Interest::all();
        return view('boards.create',compact('interests','id'));
    }

    public function edit_board(Group $record, Board $board){
        $interests=Interest::all();
        return view('boards.edit',compact('interests','board','record'));
    }

    public function update_board(Request $request, Group $record, Board $board){

        $board->name=$request->name;
        $board->description=$request->description;
        $board->save();
        $board->interests()->sync($request->interests);
        foreach ($board->sticks as $stick){
            $stick->interests()->sync($board->interests()->get());
        }
        return redirect()->route($this->pageUrl.'.board.detail',['id'=>$record->id,'board'=>$board->id]);
    }

    public function store_board(Request $request, $id){
        $group=PageModel::find($id);

        $group->publishBoard(
            $board=new Board(request(['name','description']))
        );

        foreach ($request->interests as $interest){
            $the_interest=Interest::find($interest);

            if($the_interest!=null){
                $the_interest->boards()->attach($board);

            }
        }
        return redirect()->route($this->pageUrl.'.detail',['id'=>$group->id]);
    }

    public function edit(Group $group){
        $cities=City::all();
        return view('groups.edit',compact('group','cities'));
    }

    public function update(Request $request, Group $group){

        /** Regular Inputs **/
        foreach($this->fields as $field){
            $group->$field = $request->get($field);
        }

        $group->save();
        session()->flash('success', 'Yeni '.$this->pageItem.' güncellendi.');
        return redirect()->route('groups.detail',$group->id);
    }

    public function create_wanted($id){
        return view('wanteds.create',compact('id'));
    }

    public function store_wanted(Request $request,$id){

        $group=PageModel::find($id);
        $record=new Wanted();
        if($record::$dateFields){
            foreach($record::$dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }

        auth()->user()->publishWanted(
            $wanted=new Wanted(request(['content'])),$record->deadline, $group->id);

        return redirect()->route($this->pageUrl.'.detail',['id'=>$id]);
    }

    public function update_photo(Request $request, $id){
        $record=PageModel::where('id',$id)->firstOrFail();

        if($request->hasFile('image_url')){
            $imageField=$this->imageFields[0];
            parent::handleGroupImageUpload(
                $record,
                $imageField['naming'],
                $imageField['diff'],
                $request->file('image_url'),
                $imageField['name']
            );
            $record->save();
            return redirect()->back();
        }

    }

    public function follow(Group $group){

        auth()->user()->follow_group($group);
        return redirect()->back();
    }

    public function unfollow( Group $group){

        auth()->user()->unfollow_group($group);
        return redirect()->back();
    }


    public function sticks_detail(PageModel $record, Stick $stick ){
        $boards=auth()->user()->boards()->get();
        $owned_groups=auth()->user()->ownedGroups()->get();
        $admin_of=auth()->user()->isAdminOf();
        $groups=$owned_groups->toBase()->merge($admin_of);
        return view('sticks.detail',compact('stick','record','boards','groups'));
    }

    public function boards_index(Group $group){
        $record=$group;
        $boards=$record->boards()->get();
        return view('groups.boards_index',compact('boards','record'));
    }

    public function boards_detail($id, Board $board){
        $record=Group::find($id);
        $sticks=Stick::filterForBoard($board);
        return view('groups.boards_detail', compact('record','sticks','board') );
    }


    public function create_wanted_stick(Group $group, Wanted $wanted){


        $boards=$group->boards()->get();
        $cities=City::all();

        return view('groups.create_wanted_stick',compact('boards','cities','group','wanted'));
    }

    public function store_wanted_stick(Request $request,Group $group, Wanted $wanted){

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

        $group->publishStick(
            $stick=new Stick(request(['name','content','before_price','sale_price','city_id','district_id']))
            ,$record->image_path,$record->begin_date,$record->end_date
        );
        $stick->user_id=auth()->user()->id;
        $stick->wanted_id=$wanted->id;
        $board=$group->boards()->find($request->board_id);
        if($board!=null){
            $board->sticks()->save($stick);
        }
        else{
            $board_new=new Board;
            $board_new->name=$request->board_id;
            $group->boards()->save($board_new);
            $board_new->sticks()->save($stick);
        }
        return redirect()->route($this->pageUrl.'.wanted.detail',['group'=>$group->id, 'wanted'=>$wanted->id]);
    }

    public function wanted_detail(Group $group, Wanted $wanted){
        return view('groups.wanted_detail', compact('group','wanted'));
    }

    public function user_index(Group $group){
        $record=$group;
        $users=$group->users()
           //->wherePivot('is_banned','=', false)
            ->get();
        return view('groups.users_index',compact('users','record'));
    }

    public function promote_user(Group $group, User $user){
        $group->users()->updateExistingPivot($user, array('is_admin' => 1), false);
        return redirect()->back();
    }

    public function depromote_user(Group $group, User $user){
        $group->users()->updateExistingPivot($user, array('is_admin' => 0), false);
        return redirect()->back();
    }

    public function ban_user(Group $group, User $user){
        $group->users()->updateExistingPivot($user, array('is_banned' => 1), false);
        return redirect()->back();
    }

    public function move_stick_to_board(User $user, Stick $stick,Request $request){
        $new_board=Board::find($request->board_id);
        if(!$new_board->saved_sticks()->get()->contains($stick)){
            $new_board->saved_sticks()->attach($stick);

        }
        session()->flash('success', 'Stick sizin '.$new_board->name.' boardunuza taşındı');
        return redirect()->back();
    }

    public function move_stick_to_group(User $user, Stick $stick,Request $request){
        $old_group=$stick->group_id;
        $group=Group::find($request->group_id);
        $new_board=Board::find($request->board_id);
        if($old_group==$request->group_id){
            $group=Group::find($request->group_id);
            $stick->board_id=$new_board->id;
            $stick->group_id=$group->id;
            $stick->save();
            session()->flash('success', 'Stick '.$group->name.' adlı grubun '.$stick->board->name.' boarduna taşındı');
        }
        else{

            if(!$new_board->saved_sticks()->get()->contains($stick)){
                $new_board->saved_sticks()->attach($stick);

            }

        }
        session()->flash('success', 'Stick '.$group->name.' adlı grubun '.$new_board->name.' boarduna kaydedildi');
        return redirect()->back();
    }



}
