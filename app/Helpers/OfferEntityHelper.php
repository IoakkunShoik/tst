<?php

namespace App\Helpers;

use App\Models\Offers;

class OfferEntityHelper
{
    private Offers $offer;

    public function __construct(Offers $offer = null)
    {
        if ($offer === null) $this->offer = new Offers();
        else $this->offer = $offer;
    }

    public function prepareOfferData($data): void
    {
        $this->offer->external_id = $data['id'] ?? '';
        $this->offer->mark = $data['mark'] ?? '';
        $this->offer->model = $data['model'] ?? '';
        $this->offer->generation = $data['generation'] ?? '';
        $this->offer->year = $data['year'] ?? '';
        $this->offer->run = $data['run'] ?? '';
        $this->offer->color = $data['color'] ?? '';
        $this->offer->body_type = $data['body-type'] ?? '';
        $this->offer->engine_type = $data['engine_type'] ?? '';
        $this->offer->transmission = $data['transmission'] ?? '';
        $this->offer->gear_type = $data['gear-type'] ?? '';
        $this->offer->generation_id = $data['generation_id'] ?? 0;
    }

    public function getEntity(): Offers
    {
        return $this->offer;
    }

    public function save(): bool
    {
        return $this->offer->save();
    }
}
