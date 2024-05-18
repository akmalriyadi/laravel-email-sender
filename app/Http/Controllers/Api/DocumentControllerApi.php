<?php

namespace App\Http\Controllers\Api;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use AkmalRiyadi\LaravelBackendGenerator\Enums\ItemOptions;
use App\Http\Resources\DocumentResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\DocumentServiceApi;
use AkmalRiyadi\LaravelBackendGenerator\Resources\DefaultResource;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Requests\Document\StoreDocumentRequest;

class DocumentControllerApi extends Controller
{
    use ApiCollectionResource;
    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $documentServiceApi;

    public function __construct(DocumentServiceApi $documentServiceApi)
    {
        $this->documentServiceApi = $documentServiceApi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $result = $this->documentServiceApi->all($request->all(), withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return DocumentResource::paginateCollection($result);
    }

    public function trashed(Request $request)
    {
        $result = $this->documentServiceApi->all($request->all(), ItemOptions::ONLY_TRASHED, withOption: true, filterOption: true, paginateOption: true)->toJson();
        // return $result;
        return DocumentResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->documentServiceApi->findOrFail($id, withOption: true)->toJson();
        // return $result;
        return DocumentResource::otherCollection($result);
    }

    public function store(StoreDocumentRequest $request)
    {
        $result = $this->documentServiceApi->create($request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function update(UpdateDocumentRequest $request, $id)
    {
        $result = $this->documentServiceApi->update($id, $request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function delete($id)
    {
        $result = $this->documentServiceApi->delete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function forceDelete($id)
    {
        $result = $this->documentServiceApi->forceDelete($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }

    public function restore($id)
    {
        $result = $this->documentServiceApi->restore($id)->toJson();
        // return $result;
        return $this->notCollection($result);
    }
}
