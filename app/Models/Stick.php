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
    public  $fillable=['name','content','image_path','video_path','latitude','altitude','begin_date','end_date','sticked_count','city_id','district_id' ,'user_id','wanted_id','group_id','before_price','sale_price','board_id'];
    public static $rules=array(
        'name'=>'required',
        'content'=>'required',
        'image_path'=>'required',
        'latitude'=>'required',
        'altitude'=>'required',
    );
    public static $updaterules=array(
        'name'=>'required',
        'content'=>'required',
        'latitude'=>'required',
        'altitude'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'The name of stick can not be empty',
            'content.required'=>'The content can not be empty',
            'latitude.required'=>'The location can not be empty',
            'altitude.required'=>'The location can not be empty',
        ];
    }
    public static $fields=array('name','content','latitude','altitude','city_id', 'district_id','before_price','sale_price','user_id');
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
        return $this->BelongsToMany(Interest::class);
    }

    public function boards(){
        return $this->BelongsToMany(Board::class);
    }

    public function users(){
        return $this->BelongsToMany(User::class);
    }

    public function creator(){
        return $this->BelongsTo(User::class);
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
        return Stick::where('user_id',$user->id)->get();
    }
}
