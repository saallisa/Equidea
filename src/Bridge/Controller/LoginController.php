<?php

namespace Equidea\Bridge\Controller;

use Equidea\Bridge\Repository\UserRepository;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\{Collection,Container};

use Equidea\Engine\Entity\UserEntity;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class LoginController {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @var \Equidea\Core\Utility\Container
     */
    private $container;

    /**
     * @var \Equidea\Bridge\Repository\UserRepository
     */
    private $users;

    /**
     * @var \Equidea\Engine\Entity\UserEntity
     */
    private $user;

    /**
     * @var \Equidea\Core\Utility\Collection
     */
    private $errors;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     * @param   \Equidea\Core\Http\Interfaces\ResponseInterface $response
     * @param   \Equidea\Core\Utility\Container                 $container
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function getLogin() : ResponseInterface
    {
        // Denies access for players
        $this->container
            ->retrieve('UserGuard', [$this->request, $this->response])
            ->hideGuestContent();

        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render('guest/login');
        return $this->response->withBody($content);
    }

    /**
     * @return  string
     */
    public function getLogout() : ResponseInterface
    {
        // Retrieve the session object from the user
        $session = $this->request->getSession();

        // Change the session to the logged out status
        $session->set('authenticated', false);
        $session->remove('userId');

        // Add the success message
        $params = ['success' => 'LOGOUT_SUCCESS'];

        // Send the HTTP Response
        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render('guest/login', $params);
        return $this->response->withBody($content);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function postLogin() : ResponseInterface
    {
        // Denies access for players
        $this->container
            ->retrieve('UserGuard', [$this->request, $this->response])
            ->hideGuestContent();

        // Clean the username
        $username = $this->request->post('username');
        $username = trim(htmlspecialchars($username));

        // Get the password
        $password = $this->request->post('password');

        // Create a new errors Collection
        $this->errors = $this->container->retrieve('Collection');

        // Validate the user input
        $validation = $this->validateLogin($username, $password);

        if ($validation === true) {
            $session = $this->request->getSession();
            $session->set('userId', $this->user->getId());
            $session->set('authenticated', true);
            $this->response->redirect('/');
        }
        
        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render('guest/login', ['errors' => $this->errors]);
        return $this->response->withBody($content);
    }

    /**
     * @param   string  $username
     * @param   string  $password
     *
     * @return  boolean
     */
    private function validateLogin(string $username, string $password) : bool
    {
        // Checks if every form field was filled out
        if (empty($username) || empty($password))
        {
            $this->errors->add('general', 'LOGIN_INPUT_MISSING');
            return false;
        }

        // Create new user repository
        $this->users = $this->container->retrieve('UserRepository');

        // Checks whether the username exists
        if ($this->users->usernameExists($username) == 0)
        {
            $this->errors->add('general', 'LOGIN_INPUT_INVALID');
            return false;
        }

        // Create a user Entity instance from the parameters
        $user = new UserEntity(0);
        $user->setUsername($username);

        // Fetch the id and password for the given username
        $this->user = $this->users->authenticate($user);

        // Checks if the password was correct
        if (!password_verify($password, $this->user->getPassword()))
        {
            $this->errors->add('general', 'LOGIN_INPUT_INVALID');
            return false;
        }

        // If non of the checks did fail, validation was successful
        return true;
    }
}
