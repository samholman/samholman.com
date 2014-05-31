<?php namespace SamHolman\Site\Article;

use SamHolman\Base\App,
    SamHolman\Base\File\Reader as FileReader,
    SamHolman\Site\Article\Entity as Article;

class FileRepository implements Repository
{
    private
        $_directory,
        $_fileReader,
        $_filenameParser;

    public function __construct(\DirectoryIterator $directory, FileReader $fileReader, FilenameParser $filenameParser)
    {
        $this->_directory      = $directory;
        $this->_fileReader     = $fileReader;
        $this->_filenameParser = $filenameParser;
    }

    /**
     * Returns all articles in the system
     *
     * @param int $start
     * @param int $limit
     * @return \Generator
     */
    public function findAll($start=0, $limit=1)
    {
        $files = $this->getFilesArrayObject();

        $files->uksort(
            function ($a, $b) {
                return strcmp($b, $a);
            }
        );

        $iterator = $files->getIterator();

        try {
            $iterator->seek($start);

            for ($i=0; $i<$limit; $i++) {
                if ($file = $iterator->current()) {
                    $iterator->next();

                    yield App::make(
                        '\SamHolman\Site\Article\Entity',
                        array_merge(
                            $this->_filenameParser->getDetailsFromFilename($file->getFilename()),
                            [$this->_fileReader->read($file->getPathname())]
                        )
                    );
                }
            }
        }
        catch (\OutOfBoundsException $e) {}
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

        if ($this->_fileReader->exists($path)) {
            return App::make(
                '\SamHolman\Site\Article\Entity',
                array_merge(
                    $this->_filenameParser->getDetailsFromFilename($slug),
                    [$this->_fileReader->read($path)]
                )
            );
        }
    }

    /**
     * Returns the total number of articles
     *
     * @return int
     */
    public function count()
    {
        return count($this->getFilesArrayObject());
    }

    /**
     * Returns an array object based on the loaded directory
     *
     * @return \ArrayObject
     */
    private function getFilesArrayObject()
    {
        $files = new \ArrayObject();

        foreach ($this->_directory as $file) {
            if ($this->isValidArticleFile($file)) {
                $files->offsetSet($file->getFilename(), $file->getFileInfo());
            }
        }

        return $files;
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
