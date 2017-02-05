<?php

namespace App\Notifications;

use App\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeMail extends Notification
{
    use Queueable;

    /**
     * @var Account
     */
    protected $account  = null;


    /**
     * WelcomeMail constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
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
             //       ->from(config('mail.from.address', config('app.name')))
                    ->subject('Welcome to '.config('app.name').'!')
                    ->line('This is the first message on '.$this->account->email.'.')
                    ->line('Your temporary email account will be valid until '.$this->account->expires_at.' after this you will be asked if you wish to extend this period.');
                  //  ->action('Notification Action', 'https://laravel.com');
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
