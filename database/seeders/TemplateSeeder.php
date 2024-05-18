<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\TemplateAttach;
use App\Models\TemplateWord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::truncate();
        TemplateAttach::truncate();
        TemplateWord::truncate();
        $template = Template::create([
            'title' => 'Lamaran Bahasa Inggris',
            'body' => '<p>Dear Sir/Madan<br><br>According to the information in the [socialInfo] your company requires a [position].<br><br>With this email, I have attached a CV that you can take into consideration<br><br>Thank you for reading and considering me as a [position] in the company you lead<br><br>Thank You<br>Zainnoeryadie Akmal Sobandiar<br>&nbsp;</p>'
        ]);
        TemplateAttach::create([
            'template_id' => $template->id,
            'document_id' => 1
        ]);
        TemplateWord::create([
            'template_id' => $template->id,
            'title' => 'Social info',
            'val_title' => 'socialInfo'
        ]);
        TemplateWord::create([
            'template_id' => $template->id,
            'title' => 'Position',
            'val_title' => 'position'
        ]);
    }
}
