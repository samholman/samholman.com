<?php namespace SamHolman\Article;

class FilenameParser
{
    /**
     * Returns article details based on filename
     *
     * @param string $filename
     * @return array
     */
    public function getDetailsFromFilename($filename)
    {
        $slug = basename($filename, '.md');
        $date = new \DateTime();

        $parts = explode('-', $slug);

        if (is_numeric($parts[0])) {
            $date = \DateTime::createFromFormat('dmy', array_shift($parts));
        }

        $title = ucwords(implode(' ', $parts));

        return [$slug, $date, $title];
    }
}
