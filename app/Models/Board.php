<?php
/**
 * Created by PhpStorm.
 * User: mehme
 * Date: 12.04.2019
 * Time: 09:02
 */
namespace App\Models;
use App\User;
use App\Models\Stick;
use App\Models\Group;
use App\Models\Interest;


use phpDocumentor\Reflection\Types\Array_;

class Board extends BaseModel{
    protected $table='boards';
    protected $fillable=['name','description','boardable_id','boardable_type'];
    public static $rules=array(
        'name'=>'required'
    );
    public static $updaterules=array(
        'name'=>'required',
    );
    public static function messages(){
        return[
            'name.required'=>'Board adı boş olamaz'
        ];
    }
    public static $fields=array('name','description');
    public static $imageFields=array(
         );
    public static $docFields = array(
    );
    public static $booleanFields = array(

    );
    public static $dateFields = array(
    );
    public static $urlFields = array(
    );

    public function boardable(){
        return $this->morphTo();
    }

    public function saved_sticks(){
        return $this->belongsToMany(Stick::class);
    }

    public function sticks(){
        return $this->hasMany(Stick::class);
    }

    public function interests(){
        return $this->belongsToMany(Interest::class);
    }

    public function randomStick(){
        $saved=$this->saved_sticks()
            ->where('end_date','>=',todayWithFormat('Y-m-d'))
            ->inRandomOrder()->get();
        $owned=$this->sticks()
            ->where('end_date','>=',todayWithFormat('Y-m-d'))
            ->inRandomOrder()->get();
        $sticks=$saved->toBase()->merge($owned);
        return $sticks;

    }


}

