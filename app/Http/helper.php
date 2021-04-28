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
