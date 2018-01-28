<?php

namespace Equidea\Core\Router;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Route {

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var array
     */
    private $controller;

    /**
     * @var array
     */
    private $methods;

    /**
     * @var boolean
     */
    private $ajax;

    /**
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     * @param   boolean $ajax
     */
    public function __construct(
        string $pattern,
        array $controller,
        array $methods,
        bool $ajax
    ) {
        $this->setPattern($pattern);
        $this->controller = $controller;
        $this->methods = $methods;
        $this->ajax = $ajax;
    }

    /**
     * @param   string  $pattern
     *
     * @return  void
     */
    public function setPattern(string $pattern) {
        $this->pattern = '/'.trim($pattern, '/');
    }

    /**
     * @return  string
     */
    public function getPattern() : string {
        return $this->pattern;
    }

    /**
     * @return  array
     */
    public function getController() : array {
        return $this->controller;
    }

    /**
     * @return  array
     */
    public function getMethods() : array {
        return $this->methods;
    }

    /**
     * @return  boolean
     */
    public function isAjax() : bool {
        return $this->ajax;
    }
}
