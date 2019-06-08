<?php

namespace Modules\Authentication\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetLink extends Notification implements ShouldQueue
{
    use Queueable;

    protected $actionUrl;
    protected $user;

    /**
     * Create a new notification instance.
     * @param string $actionUrl
     * @return void
     */
    public function __construct($user, string $actionUrl)
    {
        $this->actionUrl = $actionUrl;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->line(trans('cms::cms.please_reset_and_use_this_verification_code').': '.$this->user->verification_code.'.')
            ->action(
                trans('cms::cms.reset'),
                $this->actionUrl
            )
            ->line(trans('cms::cms.thank_you_for_using_our_application').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
