<?php

namespace App;

use App\Models\Board;
use App\Models\City;
use App\Models\Role;
use App\Models\Interest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Stick;
use App\Models\Group;
use App\Models\Comment;
use App\Models\Wanted;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'last_name', 'email', 'password', 'username', 'image_url', 'main_image',
        'about', 'location','rank_id', 'isBanned'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = array(
        'username' => 'unique',

    );
    public static $updaterules = array(
        'username' => 'required',
        'email'=>'required',

    );

    public static function messages()
    {
        return[
            'username.unique'=>'Bu kullanıcı adı daha önceden kullanılmış.',
            'username.required'=>'Kullanıcı adı alanı zorunludur',
            'email.unique'=>'Bu email adı daha önceden kullanılmış.',
            'email.required'=>'Email adı alanı zorunludur',
        ];
    }

    public static $fields = array('name', 'last_name', 'email', 'username',
        'about','location','rank_id'
    );
    public static $imageFields = array(
        ["name" => "image_url", "width" => 150, "height" => 200, 'crop' => false, 'naming' => 'username', 'diff' => 'photo'],
        ["name" => "main_image", "width" => 1500, "height" => 542, 'crop' => true, 'naming' => 'username', 'diff' => 'main'],


    );
    public static $imageFieldNames = array(
        'image_path', 'main_image'
       );
    public static $docFields = array(
    );
    public static $booleanFields = array(
    'isBanned'
    );
    public static $dateFields = array(
    );
    public static $urlFields = array(
    );

    public function sticks(){
        return $this->BelongsToMany(Stick::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function publishedSticks(){
        return $this->HasMany(Stick::class);
    }

    public function ownedGroups(){
        return $this->HasMany(Group::class);
    }

    public function groups(){
        return $this->BelongsToMany(Group::class)->withPivot('is_admin');
    }

    public function totalGroups(){
        return $this->ownedGroups->toBase()->merge($this->groups()->wherePivot('is_banned','0')->get());
    }

    public function isOwnerOf(Group $group){
        return $this->ownedGroups()->get()->contains($group);
    }

    public function isMemberOfThis(Group $group){
        return $this->groups()
            ->wherePivot('is_Banned',0)
            ->get()->contains($group);
    }

    public function isAdminOf(){
        return $this->groups()->wherePivot('is_admin',1)
            ->wherePivot('is_Banned',0)
            ->get();
    }

    public function isMemberOf(){
        return $this->groups()->wherePivot('is_admin',0)
            ->wherePivot('is_Banned',0)
            ->get();
    }

    public function comments(){
        return $this->HasMany(Comment::class);
    }

    public function wantedAds(){
        return $this->HasMany(Wanted::class);
    }

    public function boards(){
        return $this->morphMany('App\Models\Board','boardable');
    }

    public function followers(){
        return $this->belongsToMany('App\User','follow',
            'following_id','follower_id');
    }

    public function following(){
        return $this->belongsToMany('App\User','follow',
            'follower_id','following_id');
    }

    public function follows($username){
        return $this->following()->get()->contains('username',$username);
    }

    public function follow($username){
        $user=User::where('username',$username)->get();
        $this->following()->attach($user);
    }

    public function unfollow($username){
        $user=User::where('username',$username)->get();
        $this->following()->detach($user);
    }

    public function follow_group(Group $group){
        $this->groups()->attach($group);
    }

    public function unfollow_group(Group $group){
        $this->groups()->detach($group);
    }

    public function publishStick(Stick $stick, $image_path,$begin,$end){
        $stick->image_path=$image_path;
        $stick->begin_date=$begin;
        $stick->end_date=$end;
        $this->publishedSticks()->save($stick);
    }

    public function publishBoard(Board $board){
        $this->boards()->save($board);
    }

    public function publishWanted(Wanted $wanted, $deadline,$group_id){
        $wanted->deadline=$deadline;
        $wanted->group_id=$group_id;
        $this->wantedAds()->save($wanted);
    }

    public function publishComment(Comment $comment, $id){
        $comment->stick_id=$id;
        $this->comments()->save($comment);
    }

    public function interests(){
        return $this->belongsToMany(Interest::class);
    }

    public function isBanned(Group $group){
        if(auth()->user()->groups->contains($group)){
            return $group->users()->where('user_id',$this->id)->first()->pivot->is_banned;

        }
        return false;
    }

    public function isAdmin(Group $group){
        if($this->isOwnerOf($group)){
            return false;
        }
        if($this->groups()->wherePivot('is_Banned',0)->get()->contains($group)){

            return $group->users()->where('user_id',$this->id)->first()->pivot->is_admin;
        }
        return false;
    }

    public function location(){
        return $this->belongsTo(City::class);
    }

    public static function recommendFor(User $user){
        $users=User::query()->get();
        foreach ($user->following as $f){
            $users=$users->toBase()->merge($f->following()->get());
        }
        foreach ($user->groups as $group){
            $users=$users->toBase()->merge($group->users);
        }
        $users=$users->unique('id')->all();

        return $users;
    }

}
