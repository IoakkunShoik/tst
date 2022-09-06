<?php

namespace App\Interfaces;

interface ParserInterface
{
    public function __construct($filePath);
    public function parseData();
}
