<?php

namespace App\Services\Api;

use AkmalRiyadi\LaravelBackendGenerator\BaseServiceApi;
use App\Repositories\EmailSenderRepository;

class EmailSenderServiceApi extends BaseServiceApi
{

    /**
     * Don't remove or change $this->mainRepository variable name
     * @property EmailSenderRepository $mainRepository;
     */
    protected $mainRepository;

    public function __construct(EmailSenderRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * Send email
     * @param int $id
     * @return mixed
     */
    public function send(int $id)
    {
        try {
            $result = $this->mainRepository->send($id);
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    // Write something awesome :)
}
