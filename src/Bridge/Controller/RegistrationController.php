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
class RegistrationController {

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
        // Denies access for players
        $container->retrieve('UserGuard', [$request, $response])
            ->hideGuestContent();

        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function getRegistration() : ResponseInterface
    {
        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render('guest/registration');
        return $this->response->withBody($content);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function postRegistration() : ResponseInterface
    {
        // Clean and prepare the user input
        $input = $this->prepareInput();

        // Create a new errors Collection
        $errors = $this->container->retrieve('Collection');

        // Validate the registration data
        $validation = $this->validateRegistration($input);

        $params = [];
        $params['errors'] = $this->errors;

        // Register the user, authenticate him and redirect to the home page
        if ($validation === true) {
            $this->register($input);
            $params['success'] = 'REGISTRATION_SUCCESS';
        }

        // Send the HTTP Response
        $view = $this->container->retrieve('Template.Engine');
        $content = $view->render('guest/registration', $params);
        return $this->response->withBody($content);
    }

    /**
     * @return  array
     */
    private function prepareInput() : array
    {
        // Array for the cleaned input
        $input = [];

        // Clean the username
        $username = $this->request->post('username');
        $input['username'] = trim(htmlspecialchars($username));

        // Get the password and its confirmation
        $input['password'] = $this->request->post('password');

        // Clean the email
        $email = $this->request->post('email');
        $input['email'] = trim(htmlspecialchars($email));

        // Clean the alpha code
        $code = $this->request->post('code');
        $input['code'] = trim(htmlspecialchars($code));

        return $input;
    }

    /**
     * @param   string  $username
     *
     * @return  boolean
     */
    private function validateUsername(string $username) : bool
    {
        // Search for the given username
        $exists = $this->users->usernameExists($username);

        // Checks whether the given username is already taken by someone
        if ($exists > 0)
        {
            $this->errors->add('username', 'REGISTRATION_USERNAME_TAKEN');
            return false;
        }

        // If the username is still free, return true
        return true;
    }

    /**
     * @param   string  $email
     *
     * @return  boolean
     */
    private function validateEmail(string $email) : bool
    {
        // Search for the given email
        $exists = $this->users->emailExists($email);

        // Checks whether the given email is already taken by someone
        if ($exists > 0)
        {
            $this->errors->add('email', 'REGISTRATION_EMAIL_TAKEN');
            return false;
        }

        // If the email is still free, return true
        return true;
    }

    /**
     * @param   array   $input
     *
     * @return  boolean
     */
    private function validateRegistration(array $input)
    {
        // Create a new errors Collection
        $errors = $this->container->retrieve('Collection');

        // Create a new validation instance
        $validation = $this->container->retrieve(
            'RegistrationValidation', [$input, $errors]
        );

        // Get the alpha code from the configuration
        $alpha = $this->container->getConfig('alpha.code');

        // Get the validation result
        $success = $validation->validate($alpha);

        // Get the validation errors
        $this->errors = $validation->getErrors();

        // If validation failed, return false
        if ($success === false) {
            return $success;
        }

        $this->users = $this->container->retrieve('UserRepository');

        // If it was correct, check if the username and email are still free.
        return $this->validateUsername($input['username']) &&
            $this->validateEmail($input['email']);
    }

    /**
     * @param   array   $input
     *
     * @return  void
     */
    private function register(array $input)
    {
        // Create a new user instance
        $user = new UserEntity(0);
        $user->setUsername($input['username']);
        $password = password_hash($input['password'], PASSWORD_DEFAULT);
        $user->setPassword($password);
        $user->setEmail($input['email']);

        // Create a new user account
        $this->users->create($user);
    }
}
