<?php

namespace App\Http\Resources;

use App\Http\Shared\TransactionType;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletLogCollection extends JsonResource{

    public function toArray($request)
    {
        $current_points = (($this->type == TransactionType::expended)?((int)$this->points*-1):(int)$this->points);
        return [
            'id'=>(int)$this->id,
            'points'=>(int)$this->points,
            'previous_points'=>(int)$this->previous_points,
            'total_points'=>(int)$this->previous_points + $current_points,
            'type'=>$this->type,
            'type_name'=>__("messages.{$this->type}"),
            'points_source'=>$this->points_source,
            'points_source_name'=> __("messages.".$this->points_source),
            'date'=>date('Y-m-d',strtotime($this->created_at)),
        ];
    }
}