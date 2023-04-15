<?php


namespace App\Http\Controllers\Client\Market;


use App\Http\Controllers\Controller;
use App\Http\Service\Client\Market\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
