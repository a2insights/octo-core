<?php

namespace Octo\Marketing\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Octo\Marketing\Database\Factories\CampaignFactory;
use Octo\Marketing\Enums\CampaignContactStatus;
use Octo\Marketing\Enums\CampaignStatus;
use Octo\Marketing\Notifications\CampaignNotification;
use Octo\ObservableModel;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ObservableModel;

    public static $MAIL_CHANNEL = 'mail';

    public static $SMS_CHANNEL = 'sms';

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
    * The factory associated with the model.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    public static function newFactory()
    {
        return CampaignFactory::new();
    }

    /**
     * Check if the campaign has pending contactss.
     *
     * @return bool
     */
    public function hasPendingContacts()
    {
        return $this->contacts()
            ->wherePivot('status', CampaignContactStatus::PENDING())
            ->count() !== 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Get the contacts for the campaign.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->using(CampaignContact::class)
            ->withPivot('status', 'notified_at', 'data');
    }

    /**
    * Get the contacts for the campaign.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function pendings()
    {
        return $this->belongsToMany(Contact::class)
            ->wherePivot('status', CampaignContactStatus::PENDING())
            ->using(CampaignContact::class)
            ->withPivot('status', 'notified_at', 'data');
    }

    /**
     * Check if the campaign is draft.
     *
     * @return bool
    */
    public function isDraft()
    {
        return $this->status === CampaignStatus::DRAFT();
    }

    /**
     * Check if the campaign is active.
     *
     * @return bool
    */
    public function isActive()
    {
        return $this->status === CampaignStatus::ACTIVE();
    }

    /**
     * Check if the campaign is paused.
     *
     * @return bool
    */
    public function isPaused()
    {
        return $this->status === CampaignStatus::PAUSED();
    }

    /**
     * Check if the campaign is finished.
     *
     * @return bool
    */
    public function isFinished()
    {
        return $this->status === CampaignStatus::FINISHED();
    }

    /**
     * Check if the campaign is cancelled.
     *
     * @return bool
    */
    public function isCanceled()
    {
        return $this->status === CampaignStatus::CANCELED();
    }

    /**
    * Check if the campaign is pending.
    *
    * @return bool
    */
    public function isPending()
    {
        return $this->status === CampaignStatus::PENDING();
    }

    /**
    * Check any given status is the same as the campaign status.
    *
    * @return bool
    */
    public function hasAnyStatus(array $status): bool
    {
        return in_array($this->status, $status);
    }

    /**
     * Start the campaign.
     *
     * @return void
     */
    public function start()
    {
        if (!$this->isDraft()) {
            throw new \Exception('The campaign cant be start.');
        }

        $this->status = CampaignStatus::ACTIVE();
        $this->start_at = now();

        $this->save();

        Notification::send(
            $this->contacts,
            new CampaignNotification($this)
        );
    }

    /**
    * Pause the campaign.
    *
    * @return void
    */
    public function pause()
    {
        if (!$this->isActive()) {
            throw new \Exception('The campaign cant be paused.');
        }

        $campaigns = DB::table('jobs')
            ->where('queue', 'campaigns')
            ->get();

        $jobs = $campaigns
            ->map(fn ($p) => ['id' => $p->id ,'campaign' => unserialize(json_decode($p->payload, true)['data']['command'])->notification->campaign])
            ->where('campaign.id', $this->id)
            ->pluck('id')
            ->toArray();

        DB::table('jobs')
            ->where('queue', 'campaigns')
            ->whereIn('id', $jobs)
            ->delete();

        $this->status = CampaignStatus::PAUSED();

        if (!$this->hasPendingContacts()) {
            $this->status = CampaignStatus::FINISHED();
        }

        $this->save();
    }

    public function cancel()
    {
        if (!$this->isPaused()) {
            throw new \Exception('The campaign cant be canceled.');
        }

        $this->status = CampaignStatus::CANCELED();

        $this->save();
    }

    /**
     * Resume the campaign.
     *
     * @return void
     */
    public function resume()
    {
        if (!$this->isPaused()) {
            throw new \Exception('The campaign is not paused');
        }

        $this->status = CampaignStatus::ACTIVE();

        if (!$this->hasPendingContacts()) {
            $this->status = CampaignStatus::FINISHED();
        }

        $this->save();

        Notification::send(
            $this->pendings,
            new CampaignNotification($this)
        );
    }

    /**
     * Finish the campaign.
     *
     * @return void
     */
    public function finish() : void
    {
        if (!$this->isActive()) {
            throw new \Exception('The campaign cant be finished.');
        }

        $this->status = CampaignStatus::FINISHED();

        $this->save();
    }
}
