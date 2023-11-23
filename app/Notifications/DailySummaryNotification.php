<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class DailySummaryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $expiringToday;
    protected $mustPickUpToday;
    public function __construct($expiringToday, $mustPickUpToday)
    {
        $this->expiringToday = $expiringToday;
        $this->mustPickUpToday = $mustPickUpToday;
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
        info('Sending email notification (daily summary)');

        $countExpiringToday = $this->expiringToday->count();
        $countMustPickUpToday = $this->mustPickUpToday->count();

        $subject = "Resumen de retiros y devoluciones de préstamos del día";

        $mailMessage = (new MailMessage)
            ->subject($subject);

        if ($countExpiringToday) {
            $line = $countExpiringToday == 1 ? "Hay $countExpiringToday préstamo que debe ser devuelto hoy:" : "Hay $countExpiringToday préstamos que deben ser devueltos hoy:";
            $mailMessage->line($line);

            foreach ($this->expiringToday as $loan) {
                $user = $loan->user()->first();
                $userName = $user->name . ' ' . $user->last_name;

                $tool = $loan->tool()->first();
                $toolName = $tool->name;
                $toolID = $tool->id;

                $url = url("/loans?id=$loan->id");
                $line = "<a href=\"$url\">$userName. Herramienta: $toolName (id: $toolID)</a>";

                $mailMessage->line(new HtmlString($line));
            }
        }
        if ($countMustPickUpToday) {
            $line = $countMustPickUpToday == 1 ? "Hay $countMustPickUpToday préstamo que debe ser retirado hoy:" : "Hay $countMustPickUpToday préstamos que deben ser retirados hoy:";

            $mailMessage->line(new HtmlString("<br/>"));
            $mailMessage->line($line);

            foreach ($this->mustPickUpToday as $loan) {
                $user = $loan->user()->first();
                $userName = $user->name . ' ' . $user->last_name;

                $tool = $loan->tool()->first();
                $toolName = $tool->name;
                $toolID = $tool->id;

                $url = url("/loans?id=$loan->id");
                $line = "<a href=\"$url\">$userName. Herramienta: $toolName (id: $toolID)</a>";

                $mailMessage->line(new HtmlString($line));
            }
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
