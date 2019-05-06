<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 15.04.2019
 * Time: 08:39
 */
namespace App\Models;
use App\User;
use App\Models\Stick;


use phpDocumentor\Reflection\Types\Array_;

class Comment extends BaseModel
{
    protected $table = 'comments';
    protected $fillable = ['content','user_id','stick_id'];
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
    public static $booleanFields = array();
    public static $dateFields = array();
    public static $urlFields = array();


    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function stick(){
        return $this->BelongsTo(Stick::class);
    }
}
