<?php namespace SamHolman\Article;

class Entity
{
    private
        $_slug,
        $_content;

    public function __construct($slug, $content)
    {
        $this->_slug    = $slug;
        $this->_content = $content;
    }

    /**
     * Returns the article slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * Returns a DateTime object appropriate to the date of this article
     *
     * @return \DateTime
     */
    public function getDate()
    {
        $date = substr($this->getSlug(), 0, strpos($this->getSlug(), '-'));
        return is_numeric($date) ? \DateTime::createFromFormat('dmy', $date) : new \DateTime();
    }

    /**
     * Returns the article title
     *
     * @return string
     */
    public function getTitle()
    {
        $parts = explode('-', $this->getSlug());

        if (is_numeric($parts[0])) {
            unset($parts[0]);
        }

        return ucwords(implode(' ', $parts));
    }

    /**
     * Returns the article content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }
}
