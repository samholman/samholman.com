<?php namespace SamHolman;

use \Michelf\MarkdownExtra;

class View
{
    private
        $_vars = [];

    /**
     * @param string $template
     * @param array $vars
     * @return string
     */
    public function make($template, array $vars=null)
    {
        if ($vars) {
            foreach ($vars as $var => $val) {
                $this->_vars[$var] = $val;
            }
        }

        ob_start();
        include Config::get('view_dir') . DIRECTORY_SEPARATOR . $template . '.phtml';
        return ob_get_clean();
    }


    /**
     * @param string $var
     * @return mixed|null
     */
    public function __get($var)
    {
        return isset($this->_vars[$var]) ? $this->_vars[$var] : null;
    }

    /**
     * @param string $var
     * @return bool
     */
    public function __isset($var)
    {
        return isset($this->_vars[$var]);
    }

    /**
     * Returns text formatted with Markdown
     *
     * @param string $text
     * @return mixed
     */
    private function markdown($text)
    {
        return MarkdownExtra::defaultTransform($text);
    }
}
