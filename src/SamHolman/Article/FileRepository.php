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
            if ($this->isValidArticleFile($file)) {
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

    /**
     * Returns whether or not the given file is a valid article file for listing
     *
     * @param \DirectoryIterator $file
     * @return bool
     */
    private function isValidArticleFile(\DirectoryIterator $file)
    {
        return !$file->isDot() && $file->isReadable() &&
            $file->getExtension() == 'md' && substr($file->getFilename(), 0, 1) != '_';
    }
}
