<?php

// ----------------------------------------------------------------------
// The Controller classes
// ----------------------------------------------------------------------
$container->register('PagesController',
function(RequestInterface $req, ResponseInterface $resp, Container $cont) {
    return new \Equidea\Bridge\Controller\PagesController($req, $resp, $cont);
});
