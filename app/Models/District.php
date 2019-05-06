<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:27
 */
namespace App\Models;
use App\User;
use App\Models\City;
use App\Models\Group;


use phpDocumentor\Reflection\Types\Array_;

class District extends BaseModel
{
    protected $table = 'districts';
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
            'name.required' => 'The name of district can not be empty',
        ];
    }

    public static $fields = array('name');
    public static $image_fields = array();
    public static $imageFieldNames = array();
    public static $docFields = array();
    public static $booleanFields = array();
    public static $dateFields = array();
    public static $urlFields = array();


    public function cities()
    {
        return $this->BelongsTo(City::class);
    }


}
