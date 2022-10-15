<?php

class Database
{
    protected $filesystem = null;

    protected $last = null;

    function __construct($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getLast()
    {
        return $this->last;
    }

    private function setLast($function, $result)
    {
        $this->last = array(
            'function' => $function,
            'results' => $result,
        );
    }

    public function writeTable($table, $content, $options = array())
    {
        $function = 'writeTable';

        $results = array(
            'success' => false
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return false;
        }

        $status = $this->filesystem->writeDatabase($table . '.db', $content, $options);

        $results = array(
            'success' => empty($status) ? false : $status
        );

        $this->setLast($function, $results);

        return $status;
    }

    public function readTable($table)
    {
        $function = 'readTable';

        $results = array(
            'found' => 0,
            'returned' => 0
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return null;
        }

        $content = $this->filesystem->readDatabase($table . '.db');

        $results = array(
            'found' => sizeof($content),
            'returned' => sizeof($content)
        );

        $this->setLast($function, $results);

        return $content;
    }

    public function deleteTable($table)
    {
        $function = 'deleteTable';

        $results = array(
            'success' => false
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return false;
        }

        $status = $this->filesystem->deleteDatabase($table . '.db');

        $results = array(
            'success' => empty($status) ? false : $status
        );

        $this->setLast($function, $results);

        return $status;
    }
}
