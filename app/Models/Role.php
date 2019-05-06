<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 08:58
 */
namespace App\Models;
use App\User;

use phpDocumentor\Reflection\Types\Array_;

class Role extends BaseModel{
    protected $table='roles';
    protected $fillable=['name'];
    protected $rules=array(
        'name'=>'required'
    );
    protected $updaterules=array(
        'name'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'The name of role can not be empty'
        ];
    }
    public static $fields=array('name');
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
        return $this->hasMany(User::class);
    }


}
