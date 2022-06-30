<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio;

class ReservationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $date;
    protected $campaign;
    protected $time;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($campaign, $date, $time)
    {
        $this->campaign = $campaign;
        $this->date = $date;
        $this->time = $time;
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
        // Twilio::message($request->user()->telephone_number, 'Reservation successful, Reservation date: ' . $this->date);

        return (new MailMessage)
                    ->line('Your reservation has been confirmed')
                    ->line('Your reservation is on: ' . $this->date)
                    ->line('At: ' . $this->time)
                    ->line('Campaign site address: ' . $this->campaign->address)
                    ->action('View appointment', url('/appointments'))
                    ->line('Thank you for using AIGPS!');
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
