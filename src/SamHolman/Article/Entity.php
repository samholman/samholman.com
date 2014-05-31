<?php namespace SamHolman\Article;

class Entity
{
    private
        $_slug,
        $_date,
        $_title,
        $_content;

    public function __construct($slug, \DateTime $date, $title, $content)
    {
        $this->_slug    = $slug;
        $this->_date    = $date;
        $this->_title   = $title;
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
        return $this->_date;
    }

    /**
     * Returns the article title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
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
