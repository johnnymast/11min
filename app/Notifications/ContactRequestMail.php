<?php

namespace App\Notifications;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactRequestMail extends Notification
{
    use Queueable;

    /**
     * @var ContactFormRequest
     */
    protected $request = null;


    /**
     * ContactRequestMail constructor.
     *
     * @param ContactFormRequest $request
     */
    public function __construct(ContactFormRequest $request)
    {
        $this->request = $request;
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
                 //   ->from(config('mail.from.address', config('app.name')))
                    ->subject('ContactController form submission')
                    ->line('There is a new contact form submission.')
                    ->line('Name: '.$this->request->name)
                    ->line('Subject: '.$this->request->subject)
                    ->line('Email: '.$this->request->email)
                    ->line('Message: '.$this->request->message);
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
