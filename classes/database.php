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

    public function insertRow($table, $row_values, $options = array())
    {
        $function = 'insertRow';

        $results = array(
            'inserted' => 0
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return null;
        }

        $content = $this->readTable($table);

        if(empty($content) || !is_array($content) || sizeof($content) <= $row_id)
        {
            $content = array();
        }

        $content[] = $row_values;

        $status = $this->writeTable($table, $content, $options);

        $results = array(
            'inserted' => empty($status) ? 0 : 1
        );

        $this->setLast($function, $results);

        if($status === false)
        {
            return null;
        }

        return (sizeof($content) - 1);
    }

    public function updateRow($table, $row_id, $row_values, $options = array())
    {
        $function = 'updateRow';

        $results = array(
            'updated' => 0
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return false;
        }

        $content = $this->readTable($table);

        if(empty($content) || !is_array($content) || sizeof($content) <= $row_id)
        {
            $this->setLast($function, $results);

            return false;
        }

        $content[$row_id] = $row_values;

        $status = $this->writeTable($table, $content, $options);

        $results = array(
            'updated' => empty($status) ? 0 : 1
        );

        $this->setLast($function, $results);

        return $status;
    }

    public function deleteRow($table, $line, $options = array())
    {
        $function = 'deleteRow';

        $results = array(
            'deleted' => 0
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return false;
        }

        $content = $this->readTable($table);

        if(empty($content) || !is_array($content) || sizeof($content) <= $line)
        {
            $this->setLast($function, $results);

            return false;
        }

        unset($content[$line]);

        $status = $this->writeTable($table, $content, $options);

        $results = array(
            'deleted' => empty($status) ? 0 : 1
        );

        $this->setLast($function, $results);

        return $status;
    }

    public function selectRow($table, $row_id)
    {
        $function = 'selectRow';

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

        $row = $this->selectRows($table, 1, $row_id);

        if(empty($row) || !is_array($row) || !isset($row[0]))
        {
            $this->setLast($function, $results);

            return null;
        }

        $results = array(
            'found' => 1,
            'returned' => 1
        );

        $this->setLast($function, $results);

        return $row[0];
    }

    public function selectRows($table, $limit = null, $offset = 0, $offset_id = null)
    {
        $function = 'selectRows';

        $results = array(
            'found' => 0,
            'returned' => 0,
            'page' => 1,
            'less' => false,
            'more' => false
        );

        if(empty($table))
        {
            $results['error'] = true;
            $results['error_message'] = 'missing table';

            $this->setLast($function, $results);

            return null;
        }

        $found = $this->readTable($table);

        if(empty($found) || !is_array($found))
        {
            $this->setLast($function, $results);

            return null;
        }

        $offset = $offset_id !== null ? fn_database_offset_id($found, $limit, $offset_id) : $offset;

        $returned = array_slice($found, $offset, $limit, true);

        $less = isset($found[key(array_slice($returned, 0, 1, true)) - 1]);
        $more = isset($found[key(array_slice($returned, -1, 1, true)) + 1]);

        $results = array(
            'found' => sizeof($found),
            'returned' => sizeof($returned),
            'page' => fn_database_page($limit, $offset),
            'less' => $less,
            'more' => $more
        );

        $this->setLast($function, $results);

        return $returned;
    }
}
