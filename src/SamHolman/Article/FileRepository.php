<?php namespace SamHolman\Article;

use SamHolman\App,
    SamHolman\Article\Entity as Article;

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
        $files = new \ArrayObject();

        foreach ($this->_directory as $file) {
            if (!$file->isDot() && $file->isReadable() && substr($file->getFilename(), 0, 1) != '_') {
                $files->offsetSet($file->getFilename(), $file->getFileInfo());
            }
        }

        $files->uksort(
            function ($a, $b) {
                return strcmp($b, $a);
            }
        );

        foreach ($files->getIterator() as $file) {
            yield App::make(
                '\SamHolman\Article\Entity',
                [basename($file->getFilename(), '.md'), file_get_contents($file->getPathname())]
            );
        }
    }

    /**
     * Returns an article by slug
     *
     * @param string $slug
     * @return Article
     */
    public function find($slug)
    {
        $path = $this->_directory->getPath() . '/' .  $slug . '.md';

        if (file_exists($path)) {
            return App::make('\SamHolman\Article\Entity', [$slug, file_get_contents($path)]);
        }
    }
}
