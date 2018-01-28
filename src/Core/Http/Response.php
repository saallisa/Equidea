<?php

namespace Equidea\Core\Http;

use Equidea\Core\Http\Interfaces\ResponseInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Response implements ResponseInterface {

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $body;

    /**
     * @param   int     $code
     */
    public function __construct(int $code) {
        $this->code = $code;
    }

    /**
     * @return  int
     */
    public function getCode() : int {
        return $this->code;
    }

    /**
     * @return  string
     */
    public function getType() : string {
        return $this->type;
    }

    /**
     * @return  string
     */
    public function getBody() : string {
        return $this->body;
    }

    /**
     * @param   int $code
     *
     * @return  self
     */
    public function withCode(int $code)
    {
        $clone = clone $this;
        $clone->code = $code;
        return $clone;
    }

    /**
     * @param   string  $type
     *
     * @return  self
     */
    public function withType(string $type)
    {
        $clone = clone $this;
        $clone->type = $type;
        return $clone;
    }

    /**
     * @param   string  $body
     *
     * @return  self
     */
    public function withBody(string $body)
    {
        $clone = clone $this;
        $clone->body = $body;
        return $clone;
    }

    /**
     * @param   string  $body
     *
     * @return  void
     */
    public function setBody(string $body) {
        $this->body = $body;
    }

    /**
     * @param   string  $type
     *
     * @return  void
     */
    public function setType(string $type) {
        $this->type = $type;
    }

    /**
     * @param   string  $location
     *
     * @return  void
     */
    public function redirect(string $location)
    {
        header("Location: ".$location);
        exit;
    }
}
