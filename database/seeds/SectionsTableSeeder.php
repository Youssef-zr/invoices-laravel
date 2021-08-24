<?php

use App\Section;
use App\User;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_user = User::first()->name;

        $sections = [
            [
                "section_name" => "البنك الشعبي",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
            [
                "section_name" => "القرض الفلاحي",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
            [
                "section_name" => "مرجان",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
            [
                "section_name" => "ديكاتلون",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
            [
                "section_name" => "أسواق السلام",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
            [
                "section_name" => "العربية للطيران",
                "note" => "أول اضافة للقسم",
                "added_by" => $first_user,
            ],
        ];

        foreach ($sections as $section) {
            $new = new Section();
            $new->fill($section)->save();
        }

    }
}
