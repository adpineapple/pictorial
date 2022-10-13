<?php

class Env
{
    protected $env = null;

    function __construct()
    {
        $this->env = array(
            'application' => array(
                'url' => getenv('APPLICATION_URL'),
                'name' => getenv('APPLICATION_NAME'),
                'keywords' => getenv('APPLICATION_KEYWORDS'),
                'description' => getenv('APPLICATION_DESCRIPTION'),
                'locale' => array(
                    'language' => getenv('APPLICATION_LOCALE_LANGUAGE'),
                    'direction' => getenv('APPLICATION_LOCALE_DIRECTION')
                ),
                'copyright' => array(
                    'year' => getenv('APPLICATION_COPYRIGHT_YEAR'),
                    'holder' => getenv('APPLICATION_COPYRIGHT_HOLDER')
                ),
                'owner' => array(
                    'url' => getenv('APPLICATION_OWNER_URL'),
                    'email' => getenv('APPLICATION_OWNER_EMAIL'),
                    'firstname' => getenv('APPLICATION_OWNER_FIRSTNAME'),
                    'lastname' => getenv('APPLICATION_OWNER_LASTNAME'),
                    'fullname' => getenv('APPLICATION_OWNER_FULLNAME')
                ),
                'author' => array(
                    'url' => getenv('APPLICATION_AUTHOR_URL'),
                    'email' => getenv('APPLICATION_AUTHOR_EMAIL'),
                    'firstname' => getenv('APPLICATION_AUTHOR_FIRSTNAME'),
                    'lastname' => getenv('APPLICATION_AUTHOR_LASTNAME'),
                    'fullname' => getenv('APPLICATION_AUTHOR_FULLNAME')
                ),
                'directories' => array(
                    'root' => ROOT,
                    'public' => '/public/',
                    'resources' => '/resources/',
                    'views' => '/resources/views/',
                )
            ),
            'filesystem' => array(
                'root' => getenv('FILESYSTEM_ROOT'),
                'upload' => array(
                    'url_expiry' => 1800, // seconds
                    'max_filesize' => 10485760, // bytes
                    'supported_types' => array(
                        'image/jpeg', 'image/png', 'image/bmp', 'image/gif', 'video/mp4'
                    ),
                ),
                'directories' => array(
                    'images' => '/videos/',
                    'videos' => '/images/',
                    'thumbnails' => '/thumbnails/',
                    'templates' => '/templates/',
                    'database' => '/database/',
                    'uploads' => '/uploads/'
                )
            ),
            'view' => array(
                'layout' => 'layouts/layout.tpl',
                'navigation' => array(
                    'index' => array(

                    ),
                    'console' => array(

                    ),
                ),
            ),
        );
    }

    public function retrieve($path = '')
    {
        return fn_array_path($this->env, $path);
    }
}
