<?php

// ----------------------------------------------------------------------
// The Core classes
// ----------------------------------------------------------------------
$container->register('Template.Engine', function() use ($container) {
    $config = $container->getConfig('templating');
    return new \Equidea\Core\Templating\Engine($config);
});

// ----------------------------------------------------------------------
// The Controller classes
// ----------------------------------------------------------------------
$container->register('PagesController',
function(RequestInterface $req, ResponseInterface $resp, Container $cont) {
    return new \Equidea\Bridge\Controller\PagesController($req, $resp, $cont);
});
