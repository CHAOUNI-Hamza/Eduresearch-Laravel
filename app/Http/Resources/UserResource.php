<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LaboratoireResource;
use App\Http\Resources\EquipeResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prénom' => $this->prénom,
            'role' => $this->role,
            'email' => $this->email,
            'slug' => $this->slug,
            'laboratoire_id' => $this->laboratoire_id,
            'laboratoire' => new LaboratoireResource($this->laboratoire),
            'equipe_id' => $this->equipe_id,
            'equipe' => new EquipeResource($this->equipe),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
