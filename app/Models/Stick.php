<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 14:11
 */
namespace App\Models;
use App\User;
use App\Models\Interest;
use App\Models\Board;
use App\Models\Group;
use App\Models\Comment;
use phpDocumentor\Reflection\Types\Array_;


class Stick extends BaseModel{
    public  $table='sticks';
    public  $fillable=['name','content','image_path','link','latitude','altitude','begin_date','end_date','sticked_count','city_id','district_id' ,'user_id','wanted_id','group_id','before_price','sale_price','board_id'];
    public static $rules=array(
        'name'=>'required',
        'content'=>'required',
        'image_path'=>'required',

    );
    public static $updaterules=array(
        'name'=>'required',
        'content'=>'required',

    );
    public static function messages(){
        return[
            'name.required'=>'Stick adı boş olamaz',
            'content.required'=>'İçerik alanı boş olamaz',
            'image_path.required'=>'Resim alanı boş olamaz'

        ];
    }
    public static $fields=array('name','content','latitude','altitude','city_id', 'district_id','before_price','sale_price','link');
    public static $imageFields=array(
        ["name" => "image_path",  'crop' => true, 'naming' => 'name', 'diff' => 'image_path']

    );
    public static $imageFieldNames = array(
        "image_path"
    );
    public static $docFields = array(
    );
    public static $booleanFields = array(

    );

    protected $dates = ['begin_date', 'end_date'];

    public static $dateFields = array(
        'begin_date','end_date'
    );
    public static $urlFields = array(
    );

    public function interests(){
        return $this->BelongsToMany(Interest::class,'stick_interest','stick_id','interest_id');
    }

    public function boards(){
        return $this->BelongsToMany(Board::class);
    }

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function users(){
        return $this->BelongsToMany(User::class);
    }

    public function creator(){
        return $this->BelongsTo(User::class,'user_id');
    }

    public function group(){
        return $this->BelongsTo(Group::class);
    }

    public function comments(){
        return $this->HasMany(Comment::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public static function filterForUser($username){
        $user=User::where('username',$username)->firstOrFail();
        $sticks= $user->publishedSticks()->whereNull('group_id')->get();
        foreach ($user->boards as $board){
            $sticks=$sticks->toBase()->merge($board->saved_sticks()->get());
        }
        $sticks=$sticks->where('end_date','>=',todayWithFormat('Y-m-d'));
        $sticks=$sticks->unique('id')->all();
        return $sticks;
    }

    public static function filterForHome(User $user){
        $sticks=$user->publishedSticks()->get();
        $following=$user->following()->get();
        $groups=$user->totalGroups();
        $city=$user->location;
        $interests=$user->interests()->get();
        foreach ($following as $item){

            $sticks=$sticks->toBase()->merge($item->publishedSticks()->get());

            foreach ($item->boards as $board){
                $sticks=$sticks->toBase()->merge($board->saved_sticks()->get());
            }
        }
        foreach ($groups as $item){
            $sticks=$sticks->toBase()->merge($item->sticks()->get());
            foreach ($item->boards as $board){
                $sticks=$sticks->toBase()->merge($board->saved_sticks()->get());
            }
        }




        $local_sticks=Stick::where('city_id',$city)->get();

        foreach ($local_sticks as $local_stick){

            if(count($interests->intersect($local_stick->interests()->get()))){
                $sticks=$sticks->toBase()->add($local_stick);
            }
        }
        $sticks=$sticks->where('end_date','>=',todayWithFormat('Y-m-d'));
        $sticks=$sticks->unique('id')->all();


        return $sticks;
    }

    public static function filterForBoard(Board $board){
       $owned_sticks=$board->sticks()
           ->where('end_date','>=',todayWithFormat('Y-m-d'))
           ->get()
       ;
       $saved_sticks=$board->saved_sticks()
           ->where('end_date','>=',todayWithFormat('Y-m-d'))
           ->get();
       $sticks=$owned_sticks->toBase()->merge($saved_sticks);
       return $sticks;
    }



    public static function filterForGroup(Group $group){
        $owned=$group->sticks()
            ->where('end_date','>=',todayWithFormat('Y-m-d'))
            //->where('begin_date','>=',todayWithFormat('Y-m-d'))
            ->get();
        $sticks=$owned;
        foreach ($group->boards as $board){
            $board_sticks=$board->saved_sticks()->where('end_date','>=',todayWithFormat('Y-m-d'))
                //->where('begin_date','<=',todayWithFormat('Y-m-d'))
                ->get();
            $sticks=$sticks->toBase()->merge($board_sticks);
        }
        return $sticks;
    }



    
}
