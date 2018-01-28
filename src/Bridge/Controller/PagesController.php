<?php

namespace Equidea\Bridge\Controller;

use Equidea\Bridge\Guard\AuthenticationGuard;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class PagesController {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @var \Equidea\Core\Utility\Container
     */
    private $container;

    /**
     * @var \Equidea\Bridge\Guard\AuthenticationGuard
     */
    private $guard;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     * @param   \Equidea\Core\Http\Interfaces\ResponseInterface $response
     * @param   \Equidea\Core\Utility\Container                 $container
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
        $this->guard = $container->retrieve('AuthenticationGuard', [$request]);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function index() : ResponseInterface
    {
        $view = $this->container->retrieve('Template.Engine');

        if ($this->guard->isLoggedOut()) {
            $content = $view->render('guest/index');
        } else {
            $content = $view->render('user/index');
        }

        return $this->response->withBody($content);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function error() : ResponseInterface
    {
        $view = $this->container->retrieve('Template.Engine');

        if ($this->guard->isLoggedOut()) {
            $content = $view->render('guest/error');
        } else {
            $content = $view->render('user/error');
        }

        return $this->response->withBody($content);
    }
}
