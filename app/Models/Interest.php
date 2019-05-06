<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 07:32
 */
namespace App\Models;
use App\User;
use App\Models\Group;
use App\Models\Board;
use App\Models\Stick;
use phpDocumentor\Reflection\Types\Array_;

class Interest extends BaseModel{
    protected $table='interests';
    protected $fillable=['name','image_path'];
    protected $rules=array(
        'name'=>'required'
    );
    protected $updaterules=array(
        'name'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'The name of interest can not be empty'
        ];
    }
    public static $fields=array('name');
    public static $image_fields=array(
        ["name" => "image_path", "width" => 200, "height" => 200, 'crop' => true, 'naming' => 'name', 'diff' => 'image_path']
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

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    public function boards(){
        return $this->belongsToMany(Board::class);
    }

    public function sticks(){
        return $this->belongsToMany(Stick::class);
    }
}
