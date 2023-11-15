<?php

namespace App\Notifications\Order;

use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmWithAgentNotification extends Notification
{
    use Queueable;
    private $receivedUser;
    private $sentUser;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $receivedUser, User $sentUser, User $agent, OrderList $orderDetails)
    {
        $this->receivedUser = $receivedUser;
        $this->sentUser = $sentUser;
        $this->agent = $agent;
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
            'text' =>"#" .$this->orderDetails->order_no . " order has been placed by " . $this->sentUser->name,
            'receiver_id' => $this->receivedUser->id,
            'sender_id' => $this->sentUser->id,
            'agent_id' => $this->agent->id,
        ];
    }
}
