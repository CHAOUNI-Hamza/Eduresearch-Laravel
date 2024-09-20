<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LaboratoireResource;

class EquipeResource extends JsonResource
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
            'slug' => $this->slug,
            'laboratoire_id' => $this->laboratoire_id,
            'laboratoire' => new LaboratoireResource($this->laboratoire),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}