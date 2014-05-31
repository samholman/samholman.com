<?php namespace SamHolman\Base;

use \SamHolman\Base\Exceptions\TemplateNotFoundException,
    \Michelf\MarkdownExtra;

class View
{
    private
        $_vars = [];

    /**
     * @param string $template
     * @param array $vars
     * @param string $viewDir
     * @return string
     * @throws TemplateNotFoundException
     */
    public function make($template, array $vars=null, $viewDir=null)
    {
        if ($vars) {
            foreach ($vars as $var => $val) {
                $this->_vars[$var] = $val;
            }
        }

        $templatePath = ($viewDir ? $viewDir : Config::get('view_dir')) . DIRECTORY_SEPARATOR . $template . '.phtml';

        if (!file_exists($templatePath)) {
            throw new TemplateNotFoundException('Template "' . $template . '" not found.');
        }

        ob_start();
        include $templatePath;
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
