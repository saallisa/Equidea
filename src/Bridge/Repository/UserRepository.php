<?php

namespace Equidea\Bridge\Repository;

use Equidea\Core\Database\Database;
use Equidea\Engine\Entity\UserEntity;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class UserRepository {

    /**
     * @var \Equidea\Core\Database\Database
     */
    private $database;

    /**
     * @param   \Equidea\Core\Database\Database $database
     */
    public function __construct(Database $database) {
        $this->database = $database;
    }

    /**
     * @param   string  $username
     *
     * @return  bool
     */
    public function usernameExists(string $username) : bool
    {
        // Prepared statement for validating a username
        $sql =  'SELECT `id` FROM `users` WHERE `username` = :username LIMIT 1';

        // Run the query, fetch the results and count the number
        $result = $this->database->select($sql, ['username' => $username]);
        return count($result);
    }

    /**
     * @param   string  $email
     *
     * @return  bool
     */
    public function emailExists(string $email) : bool
    {
        // Prepared statement for validating an email
        $sql =  'SELECT `id` FROM `users` WHERE `email` = :email LIMIT 1';

        // Run the query, fetch the results and count the number
        $result = $this->database->select($sql, ['email' => $email]);
        return count($result);
    }

    /**
     * @param   \Equidea\Engine\Entity\UserEntity   $user
     *
     * @return  void
     */
    public function create(UserEntity $user)
    {
        // Prepared statement for inserting a new user
        $sql =  'INSERT INTO `users` (`username`, `password`, `email`)
                VALUES (:username, :password, :email)';

        // Bind the parameters
        $params = [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail()
        ];

        // Execute the query
        $this->database->insert($sql, $params);
    }

    /**
     * @param   \Equidea\Engine\Entity\UserEntity   $user
     *
     * @return  int
     */
    public function locate(UserEntity $user) : int
    {
        // Prepared statement for determining the users ID
        $sql =  'SELECT `id` FROM `users` WHERE `username` = :username
                AND `password` = :password AND `email` = :email LIMIT 1';

        // Bind the parameters
        $params = [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail()
        ];

        // Execute the query
        return $this->database->select($sql, $params)[0]['id'];
    }

    /**
     * @param   \Equidea\Engine\Entity\UserEntity   $user
     *
     * @return  \Equidea\Engine\Entity\UserEntity
     */
    public function authenticate(UserEntity $user) : UserEntity
    {
        // Prepare the statement for retrieving the authentication info
        $sql =  'SELECT `id`, `password` FROM `users`
                WHERE `username` = :username LIMIT 1';

        // Retrieve the user authentication info from the database
        $result = $this->database->select(
            $sql, ['username' => $user->getUsername()]
        )[0];

        // Save the results into the UserEntity
        $user->setId($result['id']);
        $user->setPassword($result['password']);

        // Return the UserEntity with auth info
        return $user;
    }
}
