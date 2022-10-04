<?php

function fn_security_sanitize($input)
{
    if(is_array($input))
    {
        return $input;
    }
    // if is string etc.
    return $input;
}

function fn_security_sanitize_path($path)
{
    return ('/' . trim(strtok(fn_security_sanitize($path), "?"), "/"));
}

function fn_security_sanitize_write($write)
{
    return $write;
}

function fn_security_sanitize_filename($filename)
{
    return strtolower(str_replace('.', '', trim(preg_replace('/\s+/', '', fn_security_sanitize(pathinfo($filename, PATHINFO_FILENAME))))));
}

function fn_security_generate_csrf_token()
{
    if(function_exists('mcrypt_create_iv'))
    {
        return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    }

    return bin2hex(openssl_random_pseudo_bytes(32));
}

function fn_security_enable_csrf_protection()
{
    if(empty($_SESSION['csrf-token']))
    {
        $_SESSION['csrf-token'] = fn_security_generate_csrf_token();
    }
}

function fn_security_validate_csrf_token()
{
    if(empty($_POST['csrf-token']) || !hash_equals($_SESSION['csrf-token'], $_POST['csrf-token']))
    {
        return false;
    }

    return true;
}

if(!function_exists('hash_equals'))
{
    function hash_equals($known_string, $user_string)
    {
        if(is_string($known_string) !== true || is_string($user_string) !== true || strlen($known_string) !== strlen($user_string))
        {
            return false;
        }

        $result = $known_string ^ $user_string;

        $return = 0;

        for($index = strlen($result) - 1; $index >= 0; $index--)
        {
            $return |= ord($result[$index]);
        }

        return $return === 0;
    }
}
