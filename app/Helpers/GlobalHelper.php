<?php

if (!function_exists('valid_date')) {
    function valid_date($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) == $date) {
            return $d;
        }
        return null;
    }
}

if (!function_exists('indo_date')) {
    function indo_date($date)
    {
        if (valid_date($date, 'd/m/Y')) {
            $expl = explode('/', $date);
            return $expl[2] . '-' . $expl[1] . '-' . $expl[0];
        }
        return null;
    }
}

if (!function_exists('sqlindo_date')) {
    function sqlindo_date($date)
    {
        $d = valid_date($date, 'Y-m-d');
        if ($d) {
            return $d->format('d/m/Y');
        }
        return null;
    }
}

if (!function_exists('sqlindo_datetime_to_date')) {
    function sqlindo_datetime_to_date($datetime)
    {
        $d = valid_date($datetime, 'Y-m-d H:i:s');
        if ($d) {
            return $d->format('d/m/Y');
        }
        return null;
    }
}

if (!function_exists('sqlindo_datetime_to_time')) {
    function sqlindo_datetime_to_time($datetime)
    {
        $d = valid_date($datetime, 'Y-m-d H:i:s');
        if ($d) {
            return $d->format('H:i');
        }
        return null;
    }
}

if (!function_exists('sqlindo_datetime_to_datetime')) {
    function sqlindo_datetime_to_datetime($datetime)
    {
        $d = valid_date($datetime, 'Y-m-d H:i:s');
        if ($d) {
            return $d->format('d/m/Y H:i:s');
        }
        return null;
    }
}

if (!function_exists('tanggalDb')) {
    function tanggalDb($date)
    {
        $exp = explode('/', $date);
        $date = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
        return $date;
    }
}

if (!function_exists('returnJson')) {
    function returnJson(bool $success, string $url)
    {
        $content = [
            'success' => $success,
            'redirect' => $url
        ];
        return $content;
    }
}
