<?php

namespace App\Console\Commands;

use App\Helpers\OfferEntityHelper;
use App\Models\Offers;
use App\Services\XmlParser;
use Illuminate\Console\Command;

class UploadVehiclesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploadVehiclesData {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загрузка данных выгрузки автомобилей в базу данных.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $xmlFileData = $this->parseFile();
        $existOffers = $this->findExistsOffers($xmlFileData);
        $this->deleteOffers($xmlFileData);

        $offersToCreate = $this->updateOffers($existOffers, $xmlFileData);
        $this->createOffers($offersToCreate);
        return 0;

    }

    private function deleteOffers($offers)
    {
        $updatingOffers = array_column($offers, 'id');
        Offers::whereNotIn('external_id', $updatingOffers)->delete();
    }

    private function createOffers($offersNewData)
    {
        foreach ($offersNewData as $newOffer) {
            $offerEntityHelper = new OfferEntityHelper();
            $offerEntityHelper->prepareOfferData($newOffer);
            $offerEntityHelper->save();
        }
    }

    private function updateOffers($offers, $offersNewData)
    {
        $offersNewDataExternalIds = array_column($offersNewData, 'id');

        foreach ($offers as $offer) {
            $newDataKey = array_search($offer->external_id, $offersNewDataExternalIds);
            $offerNewData = $offersNewData[$newDataKey];
            $offerEntityHelper = new OfferEntityHelper($offer);
            $offerEntityHelper->prepareOfferData($offerNewData);
            $offerEntityHelper->save();
            unset($offersNewData[$newDataKey]);
        }

        return $offersNewData;
    }

    private function findExistsOffers($offersArray)
    {
        $updatingOffers = array_column($offersArray, 'id');
        return  Offers::whereIn('external_id', $updatingOffers)->get();
    }

    private function parseFile()
    {
        if ($this->argument('path') !== null)
            $path = $this->argument('path');
        else
            $path = config('parser.default_path');

        $xmlParser = new XmlParser($path);
        return $xmlParser->parseData();
    }
}
