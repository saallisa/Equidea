<?php

namespace Equidea\Core\Http;

use Equidea\Core\Http\Interfaces\InputInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Input implements InputInterface {

    /**
     * @var array
     */
    private $input = [];

    /**
     * @param   array   $get
     * @param   array   $post
     */
    public function __construct(array $get, array $post)
    {
        $this->input['get'] = $get;
        $this->input['post'] = $post;
    }

    /**
     * @param   array   $get
     *
     * @return  self
     */
    public function withGet(array $get)
    {
        $clone = clone $this;
        $clone->input['get'] = $get;
        return $clone;
    }

    /**
     * @param   array   $post
     *
     * @return  self
     */
    public function withPost(array $post)
    {
        $clone = clone $this;
        $clone->input['post'] = $post;
        return $clone;
    }

    /**
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  self
     */
    public function withAddedGet(string $key, $value)
    {
        $clone = clone $this;
        $clone->input['get'][$key] = $value;
        return $clone;
    }

    /**
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  self
     */
    public function withAddedPost(string $key, $value)
    {
        $clone = clone $this;
        $clone->input['post'][$key] = $value;
        return $clone;
    }

    /**
     * @param   string  $key
     *
     * @return  self
     */
    public function withoutGet(string $key)
    {
        $clone = clone $this;
        unset($clone->input['get'][$key]);
        return $clone;
    }

    /**
     * @param   string  $key
     *
     * @return  self
     */
    public function withoutPost(string $key)
    {
        $clone = clone $this;
        unset($clone->input['get'][$key]);
        return $clone;
    }

    /**
     * @param   string  $method
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    private function input(string $method = 'get', string $name = null, $default = null)
    {
        // Checks, whether a specific value was requested
        if (isset($name))
        {
            // Does the requested value exist?
            if (isset($this->input[$method][$name]))
            {
                // Positive: return the value
                return $this->input[$method][$name];
            }
            // Negative: the default value
            return $default;
        }
        // return the entire array
        return $this->input[$method];
    }

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null) {
        return $this->input('get', $name, $default);
    }

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function post(string $name = null, $default = null) {
        return $this->input('post', $name, $default);
    }
}
