<?php

// نسبة ضريبة القيمة المضافة
if (!function_exists('rat_vat')) {
    function rat_vat()
    {
        $i = 0;
        $rat_vat = [];
        while ($i <= 100) {
            $rat_vat[$i] = $i . "%";
            $i++;
        }

        return $rat_vat;
    }
}

// admin url
if (!function_exists('adminUrl')) {
    function adminUrl($url)
    {
        return url('/admin/' . $url);
    }
}

// invoice type
if (!function_exists('invoice_type')) {
    function invoice_type()
    {
        return [
            '1' => 'مدفوعة',
            '2' => 'غير مدفوعة',
            '3' => 'مدفوعة جزئيا',
        ];
    }
}

// product selected
if (!function_exists('product_selected')) {
    function product_selected($products, $selected)
    {

        $html = "<select class='form-control' id='product' name='product'>";
        foreach ($products as $product) {

            if ($product == $selected) {
                $html .= "<option selected='selected' value='$selected'>" . $selected . "</option>";
            } else {
                $html .= "<option value='$product'>" . $product . "</option>";
            }

        }
        $html .= "</select>";

        return $html;
    }
}

// invoice status
if (!function_exists('invoice_status')) {
    function invoice_status()
    {
        return [
            1 => 'مدفوعة',
            2 => 'غير مدفوعة',
            3 => 'مدفوعة جزئيا',
        ];

    }
}

// user status
if (!function_exists('user_status')) {
    function user_status()
    {
        return [
            'مفعل' => 'مفعل',
            'غير مفعل' => 'غير مفعل',
        ];
    }
}
