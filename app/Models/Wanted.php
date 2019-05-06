<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:42
 */
namespace App\Models;
use App\User;
use App\Models\Group;


use phpDocumentor\Reflection\Types\Array_;

class Wanted extends BaseModel
{
    protected $table = 'wanted';
    protected $fillable = ['content','deadline','isResolved','user_id','group_id'];
    protected $rules = array(
        'content' => 'required',

    );
    protected $updaterules = array(
        'content' => 'required',
    );

    public static function messages()
    {
        return [
            'content.required' => 'The content can not be empty',
        ];
    }

    public static $fields = array('content');
    public static $image_fields = array();
    public static $imageFieldNames = array();
    public static $docFields = array();
    public static $booleanFields = array('isResolved');
    public static $dateFields = array('deadline');
    public static $urlFields = array();


    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function group(){
        return $this->BelongsTo(Group::class);
    }
}
