<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        try {
            return parent::filterFields([
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'roles' => Role::collection($this->roles),
                'meta' => [
                    'rel' => 'self',
                    'link' => route('users.show', $this->id)
                ]
            ]);
        } catch (\Throwable $th) {
            return [
                'hasError' => true,
                'messages' => [$th->getMessage()]
            ];
        }
    }
}
