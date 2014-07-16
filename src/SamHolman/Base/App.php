<?php namespace SamHolman\Base;

class App
{
    private

        /**
         * @var Router
         */
        $_router,

        /**
         * @var Input
         */
        $_input,

        /**
         * @var string
         */
        $_output;

    /**
     * @param Input $input
     */
    public function __construct(Router $router, Input $input)
    {
        $this->_router = $router;
        $this->_input  = $input;
    }

    /**
     * Run the app. :-)
     *
     * @return $this
     */
    public function run()
    {
        $this->_output = $this->_router->route($this->_input->getRequestPath());
        return $this;
    }

    /**
     * Output content
     *
     * @return string
     */
    public function render()
    {
        return $this->_output;
    }
}
