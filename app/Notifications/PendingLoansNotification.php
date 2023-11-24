<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PendingLoansNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $loansPending;

    public function __construct($loansPending)
    {
        $this->loansPending = $loansPending;
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
        info('Sending email notification (pending loans)');

        $count = $this->loansPending->count();
        $subject = $count == 1 ? "Hay $count préstamo pendiente de aprobación" : "Hay $count préstamos pendientes de aprobación";
        $line = $count == 1 ? 'El siguiente préstamo se encuentra pendiente de aprobación:' : 'Los siguientes préstamos se encuentran pendientes de aprobación:';

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->line($line);
            
            foreach ($this->loansPending as $loan) {
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
