<?php

namespace Octo\Marketing\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Octo\Concerns\ToSmsProvider;

class CampaignNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use ToSmsProvider;

    /**
     * Campaign instance.
     *
     * @var \Octo\Marketing\Models\Campaign
     */
    public $campaign;

    /**
     * Set channel to send this notification in.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->to(['mail']);
    }

    /**
      * to sms message
      *
      * @return
      */
    public function toSms($notifiable)
    {
        return '';
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name}.")
            ->line($this->campaign->message);
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign)
    {
        $this->campaign = $campaign;

        $this->onQueue("campaign");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return (new \Octo\Notification([
            'title' => "Campaign",
            'description' => $this->campaign->message,
        ]))->toArray();
    }
}
