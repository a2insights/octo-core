<?php

namespace Octo\Marketing\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Octo\Marketing\Database\Factories\ContactFactory;
use Octo\ObservableModel;
use Spatie\Tags\HasTags;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;
    use ObservableModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'name',
        'properties',
        'email',
        'phone_number',
        'phone_number_is_whatsapp',
        'birthday',
        'gender',
        'favorite',
    ];

    /**
     * The default model attributes
     *
     * @var array
     */
    protected $attributes = [
       'properties' => '{}',
       'status' => true
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'properties' => AsArrayObject::class,
        'phone_is_whatsapp' => 'boolean',
        'favorite' => 'boolean',
    ];

    /**
     * The attributes of kind date
     *
     * @var array
     */
    protected $dates = [
        'birthday',
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
