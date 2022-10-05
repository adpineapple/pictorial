<?php

function fn_array_path($array, $path = '', $default = null)
{
    if(empty($path))
    {
        return $array;
    }

    $keys = explode('.', $path);

    if(empty($keys) || !is_array($keys))
    {
        return $default;
    }

    foreach($keys as $key)
    {
        if(!isset($array[$key]))
        {
            return $default;
        }

        $array = $array[$key];
    }

    return $array;
}

?>