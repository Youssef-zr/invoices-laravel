<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sections = [
            [
                "section_name" => "القسم الأول",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
            [
                "section_name" => "القسم الثاني",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
            [
                "section_name" => "القسم الثالث",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
            [
                "section_name" => "القسم الرابع",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
            [
                "section_name" => "القسم الخامس",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
            [
                "section_name" => "القسم السادس",
                "note" => "أول اضافة للقسم",
                "added_by"=>"youssef"
            ],
        ];

        foreach ($sections as $section) {
            $new = new Section();
            $new->fill($section)->save();
        }
        
    }
}
