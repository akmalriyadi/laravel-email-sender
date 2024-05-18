<?php

namespace App\Repositories;

use Exception;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use AkmalRiyadi\LaravelBackendGenerator\BaseRepository;

class DocumentRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property \Illuminate\Database\Eloquent\Model|mixed $model;
     */
    protected $model;

    public function __construct(Document $model)
    {
        $this->model = $model;
    }

    /**
     * Create item
     * @param mixed $request
     * @return Model
     * @throws Exception
     */
    public function create(mixed $request)
    {
        try {
            $data = $request->all();
            $file = $request->file('file');
            $data['type'] = $file->getClientOriginalExtension();
            $data['real_name'] = $file->getClientOriginalName();
            $data['file'] = $this->uploadFileV1($request, 'file', customFieldName: $request->title);
            return $this->model->create($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(int $id, mixed $request)
    {
        try {
            $data = $request->all();
            $source = $this->model->findOrFail($id);
            if (isset($data['file'])) {
                $file = $request->file('file');
                $this->deleteFile($source->image);
                $data['type'] = $file->getClientOriginalExtension();
                $data['real_name'] = $file->getClientOriginalName();
                $data['file'] = $this->uploadFileV1($request, 'file', customFieldName: $request->title);
            }
            if ($source->name !== $request->title) {
                $data['file'] = $this->renameFile($source->file, $request->title);
            }
            return $source->update($data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Write something awesome :)
}
