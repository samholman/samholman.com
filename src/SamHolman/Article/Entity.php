<?php namespace SamHolman\Article;

class Entity
{
    private
        $_title,
        $_content;

    public function __construct($title, $content)
    {
        $this->_title   = $title;
        $this->_content = $content;
    }

    /**
     * Returns this article's title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Returns this article's content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }
}
