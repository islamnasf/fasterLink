<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'package_name' => $this->package->{'name_' . app()->getLocale()},
            'branch_type' => ($this->multi_branches) ? __('messages.branches') : __('messages.branch'),
            'subscription_period' => $this->getPeriod(),
            'start_date' => $this->start_date,
            'expiry_date' => $this->expiry_date,
            'package_price' => $this->package->peice,
        ];
    }

    private function getPeriod()
    {
        $days = Carbon::parse($this->start_date)->diffInDays($this->expiry_date);
        if ($days == 14) {
            return (app()->getLocale() == 'ar') ? "14 يوم فترة مجانية" : "14 days free period";
        } else {
            return (app()->getLocale() == 'ar') ? "عام" : "Year";
        }
    }
}
