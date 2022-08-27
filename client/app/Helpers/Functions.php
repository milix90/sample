<?php

if (!function_exists('mex_encode')) {
    /**
     * @param string $value
     * @return string
     * @throws Exception
     */
    function mex_encode(string $value): string
    {
        $item[] = random_bytes(64);
        $item[] = base64_encode($value);

        $item = array_map('bin2hex', $item);

        $index = rand(0, 1);
        $res = $item[$index];
        unset($item[$index]);
        $res .= end($item);

        if ($index == 1)
            $res .= "=";

        return $res;
    }
}

if (!function_exists('mex_decode')) {
    /**
     * @param string $value
     * @return string
     */
    function mex_decode(string $value): string
    {
        if (str_contains($value, '=')) {
            $res = substr($value, 0, (strlen($value) - 129));
        } else {
            $res = substr($value, 128);
        }

        return base64_decode(hex2bin($res));
    }
}
