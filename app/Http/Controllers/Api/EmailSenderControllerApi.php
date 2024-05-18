<?php

namespace App\Http\Controllers\Api;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use AkmalRiyadi\LaravelBackendGenerator\Enums\ItemOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\EmailSenderServiceApi;
use AkmalRiyadi\LaravelBackendGenerator\Resources\DefaultResource;
use App\Http\Requests\EmailSender\UpdateEmailSenderRequest;
use App\Http\Requests\EmailSender\StoreEmailSenderRequest;

class EmailSenderControllerApi extends Controller
{
    use ApiCollectionResource;
    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $emailSenderServiceApi;

    public function __construct(EmailSenderServiceApi $emailSenderServiceApi)
    {
        $this->emailSenderServiceApi = $emailSenderServiceApi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $result = $this->emailSenderServiceApi->all($request->all(), withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return DefaultResource::paginateCollection($result);
    }

    public function trashed(Request $request)
    {
        $result = $this->emailSenderServiceApi->all($request->all(), ItemOptions::ONLY_TRASHED, withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return DefaultResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->emailSenderServiceApi->findOrFail($id, withOption: true)->toJson();
        // return $result;
        return DefaultResource::otherCollection($result);
    }

    public function store(StoreEmailSenderRequest $request)
    {
        $result = $this->emailSenderServiceApi->create($request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function update(UpdateEmailSenderRequest $request, $id)
    {
        $result = $this->emailSenderServiceApi->update($id, $request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function delete($id)
    {
        $result = $this->emailSenderServiceApi->delete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function forceDelete($id)
    {
        $result = $this->emailSenderServiceApi->forceDelete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }
    public function send($id)
    {
        $result = $this->emailSenderServiceApi->send($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function restore($id)
    {
        $result = $this->emailSenderServiceApi->restore($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }
}
