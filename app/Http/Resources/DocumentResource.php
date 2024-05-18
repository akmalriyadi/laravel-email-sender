<?php

namespace App\Http\Resources;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = url('/');
        $parent = parent::toArray($request);
        if (isset($parent['file'])) {
            $parent['file_link'] = $baseUrl . '/upload/' . $parent['file'];
        }
        return $parent;
    }
}
