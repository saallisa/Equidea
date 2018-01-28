<?php

namespace Equidea;

use Equidea\Core\Http\Interfaces\RequestInterface;
use Equidea\Core\Http\Interfaces\ResponseInterface;

use Equidea\Core\Utility\Container;

use Equidea\Core\Router\Route;
use Equidea\Core\Router\Router;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Equidea {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @var \Equidea\Core\Router\Router;
     */
    private $router;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     * @param   \Equidea\Core\Http\Interfaces\ResponseInterface $response
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->router = new Router($request, $response, $container);
    }

    /**
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public function get(string $pattern, array $controller)
    {
        $route = new Route($pattern, $controller, ['GET'], false);
        $this->router->addRoute($route);
    }

    /**
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public function post(string $pattern, array $controller)
    {
        $route = new Route($pattern, $controller, ['POST'], false);
        $this->router->addRoute($route);
    }

    /**
     * @param   string  $pattern
     * @param   array   $controller
     * @param   string  $method
     *
     * @return  void
     */
    public function ajax(string $pattern, array $controller, string $method)
    {
        $route = new Route($pattern, $controller, [$method], true);
        $this->router->addRoute($route);
    }

    /**
     * @param   array   $action
     *
     * @return  void
     */
    public function notFound(array $controller) {
        $this->router->addNotFound($controller);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function respond() {
        return $this->router->respond();
    }
}
