<?php

namespace App\Http\Controllers\Api;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use AkmalRiyadi\LaravelBackendGenerator\Enums\ItemOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\SettingServiceApi;
use AkmalRiyadi\LaravelBackendGenerator\Resources\DefaultResource;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Requests\Setting\StoreSettingRequest;

class SettingControllerApi extends Controller
{
    use ApiCollectionResource;
    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $settingServiceApi;

    public function __construct(SettingServiceApi $settingServiceApi)
    {
        $this->settingServiceApi = $settingServiceApi;
    }

    public function show($id)
    {
        $result = $this->settingServiceApi->findOrFail($id, withOption: true)->toJson();
        // return $result;
        return DefaultResource::otherCollection($result);
    }

    public function update($id, UpdateSettingRequest $request)
    {
        $result = $this->settingServiceApi->update($id, $request)->toJson();
        // return $result;
        return $this->notCollection($result);
    }
}
