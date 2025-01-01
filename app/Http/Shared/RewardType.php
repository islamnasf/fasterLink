<?php

namespace App\Http\Shared;

class RewardType {

   static function getTypes(){
        return [
            ['id' => 1, 'name' => __('messages.material_reward')],
            ['id' => 2, 'name' => __('messages.points_added_account')]
        ];
    }
     
}