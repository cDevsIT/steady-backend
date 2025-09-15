<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class RenewEmailNotification extends Notification
{
    use Queueable;

    public function __construct($transition, $route,$history,$customer_name)
    {
        $this->transition = $transition;
        $this->route = $route;
        $this->history = $history;
        $this->customer_name = $customer_name;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $history = $this->history;
        $company = Company::find($this->transition->company_id);
        $customer_name = $this->customer_name;

        $company_name = $company->company_name;
        if ($company->business_type == "LLC"){
            $company_name = $company_name ." ".$company->llc_type;
        }elseif ($company->business_type == "Corporation"){
        $company_name = $company_name ." ".$company->corporation_type;
        }else{
            $company_name = $company_name ." ".$company->business_type;
        }

        if ($history->business_address_fee > 0){
            return (new MailMessage)
                ->subject('Renewal Mail Of: ' . $company_name)
                ->greeting('Dear ' . $customer_name . ",")
                ->line("Renew Successful and Paid")
                ->line('')
                ->line("Company:". $company_name)
                ->line("Service Fee:". $history->service_fee)
                ->line("State Fee:". $history->state_fee)
                ->line("Registered Agent and Business Address Fee:", $history->business_address_fee)
                ->line("Total Amount:". $history->total_amount)
                ->action('View Company Dashboard', $this->route)
                ->line('Thank you')
                ->line(config('app.name') . ' Team')
                ->salutation(' ');
        }else{
            return (new MailMessage)
                ->subject('Renewal Mail Of: ' . $company->title)
                ->greeting('Dear ' . $customer_name . ",")
                ->line("Renew Successful and Paid")
                ->line('')
                ->line("Service Fee:". $history->service_fee)
                ->line("State Fee:". $history->state_fee)
                ->line("Total Amount:". $history->total_amount)
                ->action('View Company Dashboard', $this->route)
                ->line('Thank you')
                ->line(config('app.name') . ' Team')
                ->salutation(' ');
        }

    }
}
