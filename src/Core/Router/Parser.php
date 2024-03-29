<?php

namespace Equidea\Core\Router;

use Equidea\Core\Http\Uri;
use Equidea\Core\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Parser {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     */
    public function __construct(RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * @param   mixed   $segment
     *
     * @return  bool
     */
    private function isParam($segment) : bool
    {
        $pos = strpos($segment, '{');
        return $pos !== false && $pos == 0;
    }

    /**
     * @param   string  $param
     *
     * @return  string
     */
    private function getParamName(string $param) : string
    {
        $param = ltrim($param, '{');
        $param = rtrim($param, '}');
        return explode(':', $param)[0];
    }

    /**
     * @param   array   $uriSegments
     * @param   array   $patternSegments
     *
     * @return  \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private function translate(
        array $uriSegments,
        array $patternSegments
    ) : RequestInterface
    {
        // The original Request Input
        $input = $this->request->getInput();
        // Determine the number of segments
        $segments = count($patternSegments);

        // Loop through the pattern segments and find the params
        for ($i = 0; $i < $segments; $i++)
        {
            // Determines whether a segment is a param
            if ($this->isParam($patternSegments[$i]))
            {
                $paramName = $this->getParamName($patternSegments[$i]);
                $input = $input->withAddedGet($paramName, $uriSegments[$i]);
            }
        }
        // Return a clone of Request with the now added GET parameters
        return $this->request->withInput($input);
    }

    /**
     * @param   \Equidea\Core\Router\Route  $route
     *
     * @return  \Equidea\Core\Http\Interfaces\RequestInterface
     */
    public function parse(Route $route) : RequestInterface
    {
        // Get the pattern
        $pattern = $route->getPattern();

        // If no parameter is present, respond with the original request
        if (strpos($pattern, '/{') === false) {
            return $this->request;
        }

        // Get the URI segments
        $originalUri = $this->request->getUri();
        $uriSegments = $originalUri->getSegments();

        // Get the pattern segments
        $patternUri = new Uri($pattern);
        $patternSegments = $patternUri->getSegments();

        // Save the URI params into the Request object and return it
        return $this->translate($uriSegments, $patternSegments);
    }
}
