<?php

namespace Equidea\Core\Http;

use Equidea\Core\Http\Interfaces\UriInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Uri implements UriInterface {

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $segments = [];

    /**
     * @param   string  $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->findSegments();
    }

    /**
     * @return  string
     */
    public function getUri() : string {
        return $this->uri;
    }

    /**
     * @return  void
     */
    public function findSegments()
    {
        // Normalize the uri and pattern
        $uri = trim($this->uri, '/');

        // Split it into its segments
        $segments = explode('/', $uri);

        $this->segments = $segments;
    }

    /**
     * @return  array
     */
    public function getSegments() : array {
        return $this->segments;
    }

    /**
     * @param   int     $key
     *
     * @return  string
     */
    public function getSegment(int $key) : string {
        return $this->segments[$key];
    }
}
