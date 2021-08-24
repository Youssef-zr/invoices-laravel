<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newInvoice extends Notification
{
    use Queueable;

    private $invoice_id;
    private $myName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id,$myName)
    {
        $this->invoice_id = $invoice_id;
        $this->myName = $myName;
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
        $url = adminUrl('invoices/'.$this->invoice_id);

        return (new MailMessage)
                    ->greeting('مرحبا '.$this->myName)
                    ->subject('اضافة فاتورة جديدة')
                    ->line('اضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', $url)
                    ->line('شكرا لاستخدامك برنامج ادارة الفواتير .');
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
