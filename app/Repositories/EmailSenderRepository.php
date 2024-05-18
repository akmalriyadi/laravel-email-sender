<?php

namespace App\Repositories;

use App\Mail\EmailSenderMail;
use Exception;
use App\Models\EmailSender;
use App\Models\EmailWordTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use AkmalRiyadi\LaravelBackendGenerator\BaseRepository;

class EmailSenderRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property \Illuminate\Database\Eloquent\Model|mixed $model;
     */
    protected $model;

    public function __construct(EmailSender $model)
    {
        $this->model = $model;
    }

    public function create(mixed $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('body_words');
            $emailCreate = $this->model->create($data);
            $bodyWords = $request->bodyWords;
            foreach ($bodyWords as $bodyword) {
                EmailWordTemplate::create([
                    'template_id' => $bodyword['template_id'],
                    'template_word_id' => $bodyword['template_word_id'],
                    'email_id' => $emailCreate->id,
                    'val' => $bodyword['val']
                ]);
            }
            DB::commit();
            if ($request->status == 'SEND') {
                $this->send($emailCreate->id);
            }
            return;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(int $id, mixed $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('body_words');
            $source = $this->model->findOrFail($id);
            $bodyWords = $request->bodyWords;
            $source->update($data);
            EmailWordTemplate::where('email_id', $source->id)->delete();
            foreach ($bodyWords as $bodyword) {
                EmailWordTemplate::create([
                    'template_id' => $bodyword['template_id'],
                    'template_word_id' => $bodyword['template_word_id'],
                    'email_id' => $source->id,
                    'val' => $bodyword['val']
                ]);
            }
            if ($request->status == 'SEND') {
                $this->send($source->id);
            }
            DB::commit();
            return;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function send($id)
    {
        try {
            $source = $this->model->with(['template', 'template.documents'])->findOrFail($id);
            $body = $this->bodyEmail($id);
            $file = [];
            foreach ($source->template->documents as $document) {
                $file[] = public_path('upload/' . $document->file);
            }
            $data = [
                'subject' => $source->subject,
                'body' => $body,
                'file' => $file
            ];

            $sender = Mail::to($source->to)->send(new EmailSenderMail($data));
            if ($sender) {
                $source->update([
                    'status' => 'SEND'
                ]);
                return 'Success';
            } else {
                $source->update([
                    'status' => 'DRAFT'
                ]);
                return 'Failure';
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Replace body word email template
     * @param int $id
     * @return string
     */
    public function bodyEmail(int $id)
    {
        try {
            $source = $this->model->with(['template', 'email_words', 'email_words.template_word'])->findOrFail($id);
            // dd($source);
            $from = [];
            $replace = [];
            foreach ($source->email_words as $word) {
                $from[] = '[' . $word->template_word->val_title . ']';
                $replace[] = $word->val;
            }
            $body = str_replace($from, $replace, $source->template->body);
            return $body;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Write something awesome :)
}
