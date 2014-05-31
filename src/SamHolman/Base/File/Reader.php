<?php namespace SamHolman\Base\File;

class Reader
{
    /**
     * Returns whether or not a file exists at the given path
     *
     * @param string $path
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Returns the contents of a file
     *
     * @param string $path
     * @return string
     */
    public function read($path)
    {
        return file_get_contents($path);
    }
}
