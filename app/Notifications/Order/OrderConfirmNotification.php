<?php

namespace App\Notifications\Order;

use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmNotification extends Notification
{
    use Queueable;
    private $receivedUser;
    private $sentUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $receivedUser, User $sentUser ,OrderList $orderDetails)
    {
        $this->receivedUser = $receivedUser;
        $this->sentUser = $sentUser;
        $this->orderDetails = $orderDetails;

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
            'type' => "Order Confirmed",
            'text' =>$this->sentUser->name . " confirms the order with order number #" . $this->orderDetails->order_no,
            'receiver_id' => $this->receivedUser->id,
            'sender_id' => $this->sentUser->id,
        ];
    }
}
