<?php

namespace App\Http\Resources;

use AkmalRiyadi\LaravelBackendGenerator\Traits\ApiCollectionResource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);
        $parent['excerpt'] = Str::limit($parent['body'] ?? '', 100);
        return $parent;
    }
}
