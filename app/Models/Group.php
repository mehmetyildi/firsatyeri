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

class Group extends BaseModel
{
    protected $table = 'groups';
    protected $fillable = ['name', 'city_id', 'description', 'purpose', 'user_id', 'image_path','isBanned'];
    public static $rules = array(
        'image_path'=>'required',
        'name' => 'required',
        'description' => 'required',
        'purpose' => 'required',

    );
    public static $updaterules = array(
        'name' => 'required',
        'description' => 'required',
        'purpose' => 'required',
    );

    public static function messages()
    {
        return [
            'name.required' => 'Grup adı boş olamaz',
            'description.required' => 'Grup açıklaması boş olamaz',
            'purpose.required' => 'Grup amacı boş olamaz',
            'image_path.required'=>'Grup resmi boş olamaz'
        ];
    }

    public static $fields = array('name', 'description', 'purpose', 'city_id');
    public static $imageFields = array(
        ["name" => "image_path", 'crop' => true, 'naming' => 'name', 'diff' => 'image_path', 'height' => '400', 'width' => '1200']

    );
    public static $imageFieldNames = array(
        "image_path"
    );
    public static $docFields = array();
    public static $booleanFields = array('isBanned');
    public static $dateFields = array();

    public static $urlFields = array();


    public function interests()
    {
        return $this->BelongsToMany(Interest::class);
    }

    public function boards()
    {
        return $this->morphMany('App\Models\Board', 'boardable');
    }

    public function users()
    {
        return $this->BelongsToMany(User::class)->withPivot(['is_admin', 'is_banned']);
    }

    public function creator()
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function sticks()
    {
        return $this->hasMany(Stick::class);
    }

    public function wantedAds()
    {
        return $this->HasMany(Wanted::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function publishStick(Stick $stick, $image_path, $begin, $end)
    {
        $stick->image_path = $image_path;
        $stick->begin_date = $begin;
        $stick->end_date = $end;
        $this->sticks()->save($stick);
    }

    public function publishBoard(Board $board)
    {
        $this->boards()->save($board);
    }

    public static function recommendFor(User $user)
    {
        $groups = Group::query()->get();
        foreach ($user->following as $f) {
            $groups = $groups->toBase()->merge($f->groups()->get());
            $groups = $groups->toBase()->merge($f->ownedGroups()->get());
        }
        $local_groups = Group::where('city_id', $user->location);
        foreach ($local_groups as $group) {
            foreach ($user->interests as $interest) {
                if ($group->interests()->contains($interest)) {
                    $groups = $groups->toBase()->merge($group->users);
                }
            }
        }
        return $groups;
    }
}
