<?php

namespace App\Repositories;

use App\Models\TemplateAttach;
use App\Models\TemplateWord;
use Exception;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use AkmalRiyadi\LaravelBackendGenerator\BaseRepository;

class TemplateRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property \Illuminate\Database\Eloquent\Model|mixed $model;
     */
    protected $model;
    protected $option;

    public function __construct(Template $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'body_words',
            'documents'
        ];
    }

    /**
     * Create item
     * @param mixed $request
     * @return Model
     * @throws Exception
     */
    public function create($request)
    {
        DB::beginTransaction();
        try {
            $template = $request->except('bodyWords', 'documents');
            $bodyWords = $request->bodyWords;
            $documents = $request->documents;
            $templateCreated = $this->model->create($template);
            // dd($bodyWords);
            foreach ($bodyWords as $bodyWord) {
                $bodyWord['template_id'] = $templateCreated->id;
                TemplateWord::create($bodyWord);
            }
            foreach ($documents as $document) {
                $document['template_id'] = $templateCreated->id;
                TemplateAttach::create($document);
            }
            DB::commit();
            return $templateCreated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $id, mixed $request)
    {
        DB::beginTransaction();
        try {
            $template = $request->except('bodyWords', 'documents');
            $bodyWords = $request->bodyWords;
            $documents = $request->documents;

            $source = $this->model->findOrFail($id);
            $sourceId = $source->id;

            $source->update($template);
            $detailBodyWord = [];
            $detailDocument = [];
            $documentId = [];
            foreach ($bodyWords as $bodyWord) {
                $bodyWord['template_id'] = $sourceId;
                TemplateWord::updateOrCreate([
                    'title' => $bodyWord['title'],
                    'template_id' => $sourceId,
                ], $bodyWord);
            }
            foreach ($documents as $document) {
                $documentId[] = $document['document_id'];
            }
            // $source->document_pivots()->async($documentId);
            // $source->body_words()->sync($detailBodyWord);
            // $source->document_pivots()->sync($detailDocument);
            // TemplateWord::where('template_id', $sourceId)->delete();
            TemplateAttach::where('template_id', $sourceId)->delete();
            // foreach ($bodyWords as $bodyWord) {
            //     $bodyWord['template_id'] = $sourceId;
            //     TemplateWord::create($bodyWord);
            // }
            foreach ($documents as $document) {
                $document['template_id'] = $sourceId;
                TemplateAttach::create($document);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Write something awesome :)
}
