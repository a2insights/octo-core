<?php

namespace Octo\Marketing\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Octo\Marketing\Database\Factories\ContactFactory;
use Octo\ObservableModel;
use Spatie\Tags\HasTags;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;
    use ObservableModel;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
       'properties' => '{}'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'properties' => AsArrayObject::class,
        'phone_is_whatsapp' => 'boolean',
        'favorite' => 'boolean',
        'birthday' => 'date',
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

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class)->using(CampaignContact::class)->withPivot('status', 'notified_at', 'data');
    }
}
