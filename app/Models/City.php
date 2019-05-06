<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:22
 */
namespace App\Models;
use App\User;
use App\Models\District;
use App\Models\Group;


use phpDocumentor\Reflection\Types\Array_;

class City extends BaseModel
{
    protected $table = 'cities';
    protected $fillable = ['name'];
    protected $rules = array(
        'name' => 'required',

    );
    protected $updaterules = array(
        'name' => 'required',
    );

    public static function messages()
    {
        return [
            'name.required' => 'The name of city can not be empty',
        ];
    }

    public static $fields = array('name');
    public static $image_fields = array();
    public static $imageFieldNames = array();
    public static $docFields = array();
    public static $booleanFields = array();
    public static $dateFields = array();
    public static $urlFields = array();


    public function districts()
    {
        return $this->HasMany(District::class);
    }

    public function groups(){
        return $this->HasMany(Group::class);
    }
}
