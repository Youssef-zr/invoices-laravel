<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = [
            [
                "product_name" => "قرض شخصي",
                "note" => "أول اضافة للقسم",
                "section_id"=>"1"
            ],
            [
                "product_name" => "قرض عقاري ",
                "note" => "أول اضافة للقسم",
                "section_id"=>"2"
            ],
            [
                "product_name" => "شراء بالتجزأة",
                "note" => "أول اضافة للقسم",
                "section_id"=>"3"
            ],
            [
                "product_name" => "قرض سفر",
                "note" => "أول اضافة للقسم",
                "section_id"=>"2"
            ],
            [
                "product_name" => "بطاقات شراء",
                "note" => "أول اضافة للقسم",
                "section_id"=>"4"
            ],
            [
                "product_name" => "تجهيزات",
                "note" => "أول اضافة للقسم",
                "section_id"=>"1"
            ],
        ];

        foreach ($products as $product) {
            $new = new Product();
            $new->fill($product)->save();
        }
    }
}
