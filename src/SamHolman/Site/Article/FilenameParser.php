<?php namespace SamHolman\Site\Article;

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
        if (substr($parts[0], 0, 1) == '_') {
            $parts[0] = substr($parts[0], 1);
        }

        if (is_numeric($parts[0])) {
            $date = \DateTime::createFromFormat('dmy', array_shift($parts));
        }

        $title = ucwords(implode(' ', $parts));

        return [$slug, $date, $title];
    }
}
