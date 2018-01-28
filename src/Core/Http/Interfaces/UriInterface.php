<?php

namespace Equidea\Core\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
interface UriInterface {

    /**
     * @return  string
     */
    public function getUri() : string;

    /**
     * @return  void
     */
    public function findSegments();

    /**
     * @return  array
     */
    public function getSegments() : array;

    /**
     * @param   int     $key
     *
     * @return  string
     */
    public function getSegment(int $key) : string;
}
