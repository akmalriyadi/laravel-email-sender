<?php

namespace App\Services\Api;

use AkmalRiyadi\LaravelBackendGenerator\BaseServiceApi;
use App\Repositories\DocumentRepository;

class DocumentServiceApi extends BaseServiceApi{

    /**
    * Don't remove or change $this->mainRepository variable name
    * @property DocumentRepository $mainRepository;
    */
    protected $mainRepository;

    public function __construct(DocumentRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Write something awesome :)
}
