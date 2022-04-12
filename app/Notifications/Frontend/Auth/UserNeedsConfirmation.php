<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserNeedsConfirmation.
 */
class UserNeedsConfirmation extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $uuid;

    /**
     * UserNeedsConfirmation constructor.
     *
     * @param $uuid
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(app_name().': '.__('exceptions.frontend.auth.confirmation.confirm'))
            ->line(__('strings.emails.auth.click_to_confirm'))
            ->action(__('buttons.emails.auth.confirm_account'), route('frontend.auth.account.confirm', $this->uuid))
            ->line(__('strings.emails.auth.thank_you_for_using_app'));
    }
}
