<?php

namespace Equidea\Core\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
interface RequestInterface {

    /**
     * @return  string
     */
    public function getMethod() : string;

    /**
     * @return  \Equidea\Core\Http\Interfaces\UriInterface
     */
    public function getUri();

    /**
     * @return  \Equidea\Core\Http\Interfaces\InputInterface
     */
    public function getInput();

    /**
     * @return  \Equidea\Core\Http\Interfaces\SessionInterface
     */
    public function getSession();

    /**
     * @return  boolean
     */
    public function isAjax() : bool;

    /**
     * @param   string  $method
     *
     * @return  self
     */
    public function withMethod(string $method);

    /**
     * @param   boolean
     *
     * @return  self
     */
    public function withAjax(bool $ajax);

    /**
     * @param   \Equidea\Core\Http\Interfaces\UriInterface  $uri
     *
     * @return  self
     */
    public function withUri(UriInterface $uri);

    /**
     * @param   \Equidea\Core\Http\Interfaces\InputInterface    $input
     *
     * @return  self
     */
    public function withInput(InputInterface $input);

    /**
     * @param   \Equidea\Core\Http\Interfaces\SessionInterface  $session
     */
    public function withSession(SessionInterface $session);

    /**
     * @return  string
     */
    public function uri() : string;

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null);

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function post(string $name = null, $default = null);

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function session(string $name = null, $default = null);
}
