<?php

namespace App\Services\Api;

use AkmalRiyadi\LaravelBackendGenerator\BaseServiceApi;
use App\Repositories\SettingRepository;

class SettingServiceApi extends BaseServiceApi{

    /**
    * Don't remove or change $this->mainRepository variable name
    * @property SettingRepository $mainRepository;
    */
    protected $mainRepository;

    public function __construct(SettingRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Write something awesome :)
}
