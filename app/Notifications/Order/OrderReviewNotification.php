<?php

namespace App\Notifications\Order;

use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReviewNotification extends Notification
{
    use Queueable;
    private $customerDetails;
    private $ord;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $customerDetails, OrderList $ord)
    {
        $this->customerDetails = $customerDetails;
        $this->ord = $ord;

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
            'type' => "Order Reviewed",
            'text' =>"You have new review of order #". $this->ord->order_no,
            'receiver_id' => $this->customerDetails->id,
            'order_no' => $this->ord->order_no,
        ];
    }
}
