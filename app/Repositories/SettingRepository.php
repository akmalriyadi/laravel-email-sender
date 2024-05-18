<?php

namespace App\Repositories;

use Exception;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use AkmalRiyadi\LaravelBackendGenerator\BaseRepository;

class SettingRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property \Illuminate\Database\Eloquent\Model|mixed $model;
     */
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function update(int $id, mixed $request)
    {
        DB::beginTransaction();
        try {
            $source = $this->model->findOrFail($id);
            $source->update($request->all());
            $this->storeConfiguration('MAIL_MAILER', $source->mailer);
            $this->storeConfiguration('MAIL_HOST', $source->host);
            $this->storeConfiguration('MAIL_PORT', $source->port);
            $this->storeConfiguration('MAIL_FROM_ADDRESS', $source->username);
            $this->storeConfiguration('MAIL_USERNAME', $source->username);
            $this->storeConfiguration('MAIL_PASSWORD', $source->password);
            $this->storeConfiguration('MAIL_ENCRYPTION', $source->encryption);
            DB::commit();
            return;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Write something awesome :)
}
