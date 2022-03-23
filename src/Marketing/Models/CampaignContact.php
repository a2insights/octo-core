<?php

namespace Octo\Marketing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Octo\Marketing\Database\Factories\CampaignContactFactory;
use Octo\Marketing\Enums\CampaignContactStatus;

class CampaignContact extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'notified_at',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'status' => CampaignContactStatus::class,
    ];

    /**
     * The attributes defaults.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'PENDING',
    ];

    /**
     * The factory associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function newFactory()
    {
        return CampaignContactFactory::new();
    }

    /**
    * Check if the campaign is pending.
    *
    * @return bool
    */
    public function isPending()
    {
        return $this->status === CampaignContactStatus::PENDING();
    }

    /**
    * Check if the campaign is canceled.
    *
    * @return bool
    */
    public function isCanceled()
    {
        return $this->status === CampaignContactStatus::CANCELED();
    }

    /**
    * Check if the campaign is notified.
    *
    * @return bool
    */
    public function isNotified()
    {
        return $this->status === CampaignContactStatus::NOTIFIED();
    }

    /**
    * Check if the campaign is failed.
    *
    * @return bool
    */
    public function isFailed()
    {
        return $this->status === CampaignContactStatus::FAILED();
    }
}
