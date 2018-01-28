<?php

namespace Equidea\Bridge\Guard;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class UserGuard extends AuthenticationGuard {

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response
    ) {
        parent::__construct($request);
        $this->response = $response;
    }

    /**
     * @return  void
     */
    public function protectUserContent()
    {
        if ($this->isLoggedOut()) {
            $this->response->redirect('/login');
        }
    }

    /**
     * @return  void
     */
    public function hideGuestContent()
    {
        if ($this->isLoggedIn()) {
            $this->response->redirect('/');
        }
    }
}
