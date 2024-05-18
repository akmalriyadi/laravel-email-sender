<?php

namespace App\Http\Controllers;

use App\Repositories\EmailSenderRepository;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $emailSenderRepository;

    public function __construct(EmailSenderRepository $emailSenderRepository)
    {
        $this->emailSenderRepository = $emailSenderRepository;
    }
    public function test($id)
    {
        return $this->emailSenderRepository->send($id);
    }
}
