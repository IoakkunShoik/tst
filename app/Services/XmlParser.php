<?php

namespace App\Services;

use App\Interfaces\ParserInterface;
use Orchestra\Parser\Xml\Facade as XmlLib;

class XmlParser implements ParserInterface
{
    private \Laravie\Parser\Document $xmlParser;

    public function __construct($filePath)
    {
        $this->xmlParser = XmlLib::load($filePath);
    }

    public function parseData()
    {
        return $this->xmlParser->parse([
            'offers' => ['uses' => 'offers.offer[id,mark,model,generation,year,run,color,body-type,engine-type,transmission,gear-type,generation_id]'],
        ])['offers'];

    }
}
