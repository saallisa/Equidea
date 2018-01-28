<?php

namespace Equidea\Bridge\Guard;

use Equidea\Core\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class AuthenticationGuard {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    protected $request;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     */
    public function __construct(RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * @return  boolean
     */
    public function isLoggedIn() : bool
    {
        return $this->request->session('authenticated') === true &&
            !empty($this->request->session('userId'));
    }

    /**
     * @return  boolean
     */
    public function isLoggedOut() : bool {
        return $this->isLoggedIn() === false;
    }
}
