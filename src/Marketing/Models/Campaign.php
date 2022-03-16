<?php

namespace Octo\Marketing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Octo\Marketing\Database\Factories\CampaignFactory;
use Octo\Marketing\Enums\CampaignStatus;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'message',
        'start_at',
        'end_at',
        'recurrent',
        'properties',
    ];

    /**
     * The default model attributes
     *
     * @var array
     */
    protected $attributes = [
        'properties' => '{}',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'array',
        'status' => CampaignStatus::class,
    ];

    /**
     * Get the contacts for the campaign.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    /**
    * The factory associated with the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    public static function newFactory()
    {
        return CampaignFactory::new();
    }
}
