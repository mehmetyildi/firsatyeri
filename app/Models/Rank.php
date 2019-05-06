<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 14:32
 */
namespace App\Models;
use App\User;

class Rank extends BaseModel{
    protected $table='ranks';
    protected $fillable=['name','order'];
    protected $rules=array(
        'name'=>'required',
        'order'=>'required',
    );
    protected $updaterules=array(
        'name'=>'required',
        'order'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'The name of rank can not be empty',
            'order.required'=>'The order of rank can not be empty',
        ];
    }
    public static $fields=array('name','order');
    public static $image_fields=array(

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
        return $this->HasMany(User::class);
    }


}
