<?php namespace SamHolman\Article;

use SamHolman\App;

class FileRepository implements Repository
{
    private
        $_directory;

    public function __construct(\DirectoryIterator $directory)
    {
        $this->_directory = $directory;
    }

    /**
     * Returns all articles in the system
     *
     * @return \Generator
     */
    public function findAll()
    {
        foreach ($this->_directory as $file) {
            if (!$file->isDot() && $file->isReadable()) {
                yield App::make(
                    '\SamHolman\Article\Entity',
                    array(basename($file->getFilename(), '.md'), file_get_contents($file->getPathname()))
                );
            }
        }
    }
}
