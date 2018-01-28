<?php

namespace Equidea\Core\Utility;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Collection {

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public function add(string $name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * @param   string  $name
     *
     * @return  mixed
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $this->data[$name];
        }
    }

    /**
     * @param   string  $name
     *
     * @return  boolean
     */
    public function has(string $name) : bool {
        return array_key_exists($name, $this->data);
    }
}
