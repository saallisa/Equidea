<?php

namespace Equidea\Core\Router;

use Equidea\Core\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Matcher {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $tokens = [
        ':alpha' => '[A-Za-z]+',
        ':num' => '[0-9]+',
        ':alphanum' => '[A-Za-z0-9]+',
        '' => '[0-9]+'
    ];

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     */
    public function __construct(RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * @param   string  $token
     * @param   string  $pattern
     *
     * @return  string
     */
    private function translate(string $token, string $pattern) : string
    {
        // Searches the route pattern for placeholders like {id:num}
        $search = '#[\{][a-z0-9]+'.$token.'[\}]#';
        // The regular expression to be exchanged with the token name
        $replacement = $this->tokens[$token];
        // Turns the route param into a regular expression
        $result = preg_replace($search, $replacement, $pattern);

        return $result;
    }

    /**
     * @param   \Equidea\Core\Router\Route  $route
     *
     * @return  string
     */
    private function parse(Route $route) : string
    {
        // The parameter token namespace
        $tokens = array_keys($this->tokens);
        // The route pattern
        $pattern = $route->getPattern();

        // Search for all kinds of parameters and translate them
        foreach ($tokens as $token) {
            $pattern = $this->translate($token, $pattern);
        }

        // The parsed regular expression ready for matching
        return '#^'.$pattern.'$#D';
    }

    /**
     * @param   \Equidea\Core\Router\Route  $route
     *
     * @return  boolean
     */
    public function match(Route $route) : bool
    {
        // The pattern translated into a regex
        $regex = $this->parse($route);
        // The route methods
        $methods = $route->getMethods();
        // The current uri
        $uriObject = $this->request->getUri();
        $uri = '/'.trim($uriObject->getUri(), '/');
        // The current http method
        $method = $this->request->getMethod();

        return preg_match($regex, $uri) && in_array($method, $methods) &&
            $this->request->isAjax() === $route->isAjax();
    }
}
