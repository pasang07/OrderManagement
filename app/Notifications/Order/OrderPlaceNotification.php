<?php

namespace App\Notifications\Order;

use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\User\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaceNotification extends Notification
{
    use Queueable;
    private $receivedUser;
    private $sentUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $receivedUser, User $sentUser)
    {
        $this->receivedUser = $receivedUser;
        $this->sentUser = $sentUser;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'type' => "New Order Request",
            'text' =>"New Order has been placed from " . $this->sentUser->name,
            'receiver_id' => $this->receivedUser->id,
            'sender_id' => $this->sentUser->id,
        ];
    }
}
