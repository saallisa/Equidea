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
class AbstractBaseController {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    protected $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    protected $response;

    /**
     * @var \Equidea\Core\Utility\Container
     */
    protected $container;

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
    }

    /**
     * @param   string  $template
     * @param   array   $data
     *
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    protected function render(string $template, array $data) : ResponseInterface
    {
        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render($template, $data);
        return $this->response->withBody($content);
    }
}
