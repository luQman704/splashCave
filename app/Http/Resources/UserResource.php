<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $isSubscribed = false;
        $isSaved = false;
        $user = Auth::user();
        foreach ($user->userSubscriptions as $sub){
            if($sub->subscribedUser->id === $this->id){
                $isSubscribed = $sub->id;
            }
        }
        foreach ($user->userSaves as $saves){
            if($saves->savedUser->id === $this->id){
                $isSaved = $saves->id;
            }
        }
        return [
            'userName' => $this->user_name,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'id' => $this->id,
            'company' => $this->company_name,
            'phone_number' => $this->phone_number,
            'posts'      => $this->posts,
            'isSubscribed' => $isSubscribed,
            'location' =>$this->location,
            'isSaved' => $isSaved
        ];
    }
}
