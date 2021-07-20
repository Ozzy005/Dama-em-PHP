<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class AutoLoader
{
    protected $directories;

    public function addDirectory($directory)
    {
        $this->directories[] = $directory;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass($class)
    {
        $folders = $this->directories;

        foreach ($folders as $folder)
        {
            if (file_exists("{$folder}/{$class}.php"))
            {
                require_once "{$folder}/{$class}.php";
                break;
            }
        }
    }
}