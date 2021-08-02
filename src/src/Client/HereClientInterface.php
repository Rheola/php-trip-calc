<?php

namespace App\Client;

interface HereClientInterface
{
    public function sendRouteRequest();

    public function getCalcRouteResult();
}