<?php

namespace Equidea\Bridge\Validation;

use Equidea\Core\Utility\Collection;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class RegistrationValidation {

    /**
     * @var array
     */
    private $input;

    /**
     * @var \Equidea\Core\Utility\Collection
     */
    private $errors;

    /**
     * @param   array                               $input
     * @param   \Equidea\Core\Utility\Collection    $errors
     */
    public function __construct(array $input, Collection $errors)
    {
        $this->input = $input;
        $this->errors = $errors;
    }

    /**
     * @return  boolean
     */
    private function checkUsername() : bool
    {
        // Checks if the username field is empty
        if (empty($this->input['username']))
        {
            $this->errors->add('general', 'REGISTRATION_INPUT_MISSING');
            return false;
        }

        // Checks if the username is too short
        if (strlen($this->input['username']) < 4)
        {
            $this->errors->add('username', 'REGISTRATION_USERNAME_TOO_SHORT');
            return false;
        }

        // Checks if the username is too long
        if (strlen($this->input['username']) > 20)
        {
            $this->errors->add('username', 'REGISTRATION_USERNAME_TOO_LONG');
            return false;
        }

        // Checks if the username has disallowed characters
        $pattern = '#^[A-Za-zÄÖÜäöü][A-Za-zÄÖÜäöüß0-9]+$#';

        if (!preg_match($pattern, $this->input['username']))
        {
            $this->errors->add('username', 'REGISTRATION_USERNAME_INVALID');
            return false;
        }

        // If no error was found, return true
        return true;
    }

    /**
     * @return  boolean
     */
    private function checkPassword() : bool
    {
        // Checks if the password field is empty
        if (empty($this->input['password']))
        {
            $this->errors->add('general', 'REGISTRATION_INPUT_MISSING');
            return false;
        }

        // Checks if the password is too short
        if (strlen($this->input['password']) < 8)
        {
            $this->errors->add('password', 'REGISTRATION_PASSWORD_TOO_SHORT');
            return false;
        }

        // Checks if the password is too long
        if (strlen($this->input['password']) > 64)
        {
            $this->errors->add('password', 'REGISTRATION_PASSWORD_TOO_LONG');
            return false;
        }

        // If no error was found, validation succeeds.
        return true;
    }

    /**
     * @return  boolean
     */
    private function checkEmail() : bool
    {
        // Checks if the email field is empty
        if (empty($this->input['email']))
        {
            $this->errors->add('general', 'REGISTRATION_INPUT_MISSING');
            return false;
        }

        // Checks whether a valid email has been provided
        if (!filter_var($this->input['email'], FILTER_VALIDATE_EMAIL))
        {
            $this->errors->add('email', 'REGISTRATION_EMAIL_INVALID');
            return false;
        }

        // If no check failed, return true;
        return true;
    }

    /**
     * @param   string  $code
     *
     * @return  boolean
     */
    private function checkCode(string $code) : bool
    {
        // Checks if the email field is empty
        if (empty($this->input['code']))
        {
            $this->errors->add('general', 'REGISTRATION_INPUT_MISSING');
            return false;
        }

        // Checks whether a valid code has been provided
        if ($this->input['code'] != $code)
        {
            $this->errors->add('code', 'REGISTRATION_CODE_INVALID');
            return false;
        }

        // If no check failed, return true;
        return true;
    }

    /**
     * @param   string  $code
     *
     * @return  boolean
     */
    public function validate(string $code) : bool
    {
        // Check the form fields
        $username = $this->checkUsername();
        $password = $this->checkPassword();
        $email = $this->checkEmail();
        $code = $this->checkCode($code);

        // Return if all validations where true
        return $username && $password && $email && $code;
    }

    /**
     * @return  \Equidea\Bridge\Utility\Collection
     */
    public function getErrors() : Collection {
        return $this->errors;
    }
}
