<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportRetributionNotification extends Notification
{
    use Queueable;
    public $namaBendahara, $rt, $fileUrl, $bulan, $tahun;
    /**
     * Create a new notification instance.
     */
    public function __construct($namaBendahara, $rt, $fileUrl, $bulan, $tahun)
    {
        $this->namaBendahara = $namaBendahara;
        $this->rt = $rt;
        $this->fileUrl = $fileUrl;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "Laporan Retribusi {$this->rt}",
            'message' => "{$this->namaBendahara} mengunggah laporan bulan {$this->bulan} {$this->tahun}.",
            'url' => $this->fileUrl,
            'type' => 'success', // bisa juga 'warning', 'info'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
