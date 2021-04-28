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
                "product_name" => "المنتج الأول",
                "note" => "أول اضافة للقسم",
                "section_id"=>"1"
            ],
            [
                "product_name" => "المنتج الثاني",
                "note" => "أول اضافة للقسم",
                "section_id"=>"2"
            ],
            [
                "product_name" => "المنتج الثالث",
                "note" => "أول اضافة للقسم",
                "section_id"=>"3"
            ],
            [
                "product_name" => "المنتج الرابع",
                "note" => "أول اضافة للقسم",
                "section_id"=>"2"
            ],
            [
                "product_name" => "المنتج الخامس",
                "note" => "أول اضافة للقسم",
                "section_id"=>"4"
            ],
            [
                "product_name" => "المنتج السادس",
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
