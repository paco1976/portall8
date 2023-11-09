<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class LoanLiberatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $loansLiberated;
    public function __construct($loansLiberated)
    {
        $this->loansLiberated = $loansLiberated;
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
        info('Sending email notification (loans liberated)');

        $count = $this->loansLiberated->count();
        $subject = $count == 1 ? "Se ha liberado $count préstamo sin retirar" : "Se han liberado $count préstamos sin retirar";
        $line = $count == 1 ? 'Se ha liberado el siguiente préstamo:' : 'Se han liberado los siguientes préstamos:';

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->line($line);

        foreach ($this->loansLiberated as $loan) {
            $user = $loan->user()->first();
            $userName = $user->name . ' ' . $user->last_name;

            $tool = $loan->tool()->first();
            $toolName = $tool->name;
            $toolID = $tool->id;

            $url = url("/loans?id=$loan->id");
            $line = "<a href=\"$url\">$userName. Herramienta: $toolName (id: $toolID)</a>";

            $mailMessage->line(new HtmlString($line));
        }

        return $mailMessage;
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
