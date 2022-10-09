<?php

class Session
{
    protected $session = null;

    function __construct()
    {
        session_start();

        fn_security_enable_csrf_protection();

        $this->session = array(
            'csrf-token' => $_SESSION['csrf-token']
        );
    }

    public function retrieve($path = '')
    {
        return fn_array_path($this->session, $path);
    }
}

?>