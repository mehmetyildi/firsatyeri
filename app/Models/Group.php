<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 14:37
 */
namespace App\Models;
use App\User;
use App\Models\Interest;
use App\Models\Board;
use App\Models\Wanted;
use App\Models\Stick;


use phpDocumentor\Reflection\Types\Array_;

class Group extends BaseModel{
    protected $table='groups';
    protected $fillable=['name','city_id','description','purpose','user_id','image_path'];
    protected $rules=array(
        'name'=>'required',
        'description'=>'required',
        'purpose'=>'required',

    );
    protected $updaterules=array(
        'name'=>'required',
        'description'=>'required',
        'purpose'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'The name of group can not be empty',
            'description.required'=>'The description can not be empty',
            'purpose.required'=>'The purpose can not be empty',
        ];
    }
    public static $fields=array('name','description','purpose','city_id');
    public static $imageFields=array(
        ["name" => "image_path", 'crop' => true, 'naming' => 'name', 'diff' => 'image_path','height'=>'400', 'width'=>'1200']

    );
    public static $imageFieldNames = array(
        "image_path"
    );
    public static $docFields = array(
    );
    public static $booleanFields = array(

    );
    public static $dateFields = array(
    );

    public static $urlFields = array(
    );


    public function interests(){
        return $this->BelongsToMany(Interest::class);
    }

    public function boards(){
        return $this->morphMany('App\Models\Board','boardable');
    }

    public function users(){
        return $this->BelongsToMany(User::class);
    }

    public function creator(){
        return $this->BelongsTo(User::class);
    }

    public function sticks(){
        return $this->hasMany(Stick::class);
    }

    public function wantedAds(){
        return $this->HasMany(Wanted::class);
    }

    public function publishStick(Stick $stick, $image_path,$begin,$end){
        $stick->image_path=$image_path;
        $stick->begin_date=$begin;
        $stick->end_date=$end;
        $this->sticks()->save($stick);
    }

    public function publishBoard(Board $board){
        $this->boards()->save($board);
    }
}
