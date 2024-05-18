<?php

namespace App\Services\Api;

use AkmalRiyadi\LaravelBackendGenerator\BaseServiceApi;
use App\Repositories\TemplateRepository;

class TemplateServiceApi extends BaseServiceApi{

    /**
    * Don't remove or change $this->mainRepository variable name
    * @property TemplateRepository $mainRepository;
    */
    protected $mainRepository;

    public function __construct(TemplateRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Write something awesome :)
}
