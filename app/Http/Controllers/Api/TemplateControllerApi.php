<?php

namespace App\Http\Controllers\Api;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use AkmalRiyadi\LaravelBackendGenerator\Enums\ItemOptions;
use App\Http\Resources\TemplateResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\TemplateServiceApi;
use AkmalRiyadi\LaravelBackendGenerator\Resources\DefaultResource;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Http\Requests\Template\StoreTemplateRequest;

class TemplateControllerApi extends Controller
{
    use ApiCollectionResource;
    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $templateServiceApi;

    public function __construct(TemplateServiceApi $templateServiceApi)
    {
        $this->templateServiceApi = $templateServiceApi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $result = $this->templateServiceApi->all($request->all(), withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return TemplateResource::paginateCollection($result);
    }

    public function trashed(Request $request)
    {
        $result = $this->templateServiceApi->all($request->all(), ItemOptions::ONLY_TRASHED, withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return TemplateResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->templateServiceApi->findOrFail($id, withOption: true)->toJson();
        // return $result;
        return TemplateResource::otherCollection($result);
    }

    public function store(StoreTemplateRequest $request)
    {
        $result = $this->templateServiceApi->create($request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function update(UpdateTemplateRequest $request, $id)
    {
        $result = $this->templateServiceApi->update($id, $request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function delete($id)
    {
        $result = $this->templateServiceApi->delete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function forceDelete($id)
    {
        $result = $this->templateServiceApi->forceDelete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function restore($id)
    {
        $result = $this->templateServiceApi->restore($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }
}
