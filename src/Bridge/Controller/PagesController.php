<?php

namespace Equidea\Bridge\Controller;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class PagesController extends AbstractBaseController {

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
        parent::__construct($request, $response, $container);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function index() : ResponseInterface {
        return $this->response->withBody('Hello World');
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function error() : ResponseInterface {
        return $this->response->withCode(404)->withBody('404: Not Found');
    }
}
