<?php

namespace Equidea\Core\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
interface InputInterface {

    /**
     * @param   array   $get
     *
     * @return  self
     */
    public function withGet(array $get);

    /**
     * @param   array   $post
     *
     * @return  self
     */
    public function withPost(array $post);

    /**
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  self
     */
    public function withAddedGet(string $key, $value);

    /**
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  self
     */
    public function withAddedPost(string $key, $value);

    /**
     * @param   string  $key
     *
     * @return  self
     */
    public function withoutGet(string $key);

    /**
     * @param   string  $key
     *
     * @return  self
     */
    public function withoutPost(string $key);

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
}
