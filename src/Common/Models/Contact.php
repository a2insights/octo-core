<?php

namespace Octo\Common\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Octo\Common\database\factories\ContactFactory;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_type',
        'contact_id',
        'status',
        'name',
        'properties',
        'nickname',
        'email',
        'phone',
        'mobile_phone',
        'mobile_phone_is_whatsapp',
        'birthday',
        'gender',
        'favorite',
        'notificable',
        'loggable',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'properties' => 'array',
        'mobile_phone_is_whatsapp' => 'boolean',
        'favorite' => 'boolean',
        'notificable' => 'boolean',
        'loggable' => 'boolean',
    ];

    /**
     * The factory associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return ContactFactory::new();
    }
}
