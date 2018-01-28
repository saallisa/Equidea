<?php

namespace Equidea\Core\Utility;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Container {

    /**
     * @var array
     */
    private $configuration = [];

    /**
     * @var array
     */
    private $services = [];

    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public function setConfig(string $name, $value) {
        $this->configuration[$name] = $value;
    }

    /**
     * @param   string  $name
     *
     * @return  mixed
     */
    public function getConfig(string $name) {
        return $this->configuration[$name];
    }

    /**
     * @param   string      $name
     * @param   callable    $service
     *
     * @return  void
     */
    public function register(string $name, callable $service) {
        $this->services[$name] = $service;
    }

    /**
     * @param   string  $name
     * @param   array   $arguments
     *
     * @return  mixed
     */
    public function retrieve(string $name, array $arguments = []) {
        $class = $this->services[$name];
        return call_user_func_array($class, $arguments);
    }
}
