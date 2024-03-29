<?php

namespace Equidea\Core\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
interface ResponseInterface {

    /**
     * @return  int
     */
    public function getCode() : int;

    /**
     * @return  string
     */
    public function getType() : string;

    /**
     * @return  string
     */
    public function getBody() : string;

    /**
     * @param   int $code
     *
     * @return  self
     */
    public function withCode(int $code);

    /**
     * @param   string  $type
     *
     * @return  self
     */
    public function withType(string $type);

    /**
     * @param   string  $body
     *
     * @return  self
     */
    public function withBody(string $body);

    /**
     * @param   string  $body
     *
     * @return  void
     */
    public function setBody(string $body);

    /**
     * @param   string  $type
     *
     * @return  void
     */
    public function setType(string $type);

    /**
     * @param   string  $location
     *
     * @return  void
     */
    public function redirect(string $location);
}
