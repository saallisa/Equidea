<?php

namespace Equidea\Core\Database;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Connection {

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @param   array   $config
     */
    public function __construct(array $config) {
        $this->connect($config);
    }

    /**
     * @param   array   $config
     *
     * @return  void
     */
    private function connect(array $config)
    {
        // Build DSN
        $dns = 'mysql:host='.$config['server'].';dbname='.$config['database'];

        // Set options
        $options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$config['charset']
        );

        // Create new PDO object
        $this->connection = new \PDO(
            $dns, $config['username'], $config['password'], $options
        );
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  \PDOStatement
     */
    private function preparedStmt($sql, array $params)
    {
        // Prepare SQL
        $sql = trim($sql);
        $stmt = $this->connection->prepare($sql);

        // Bind parameters
        $names = array_keys($params);
        $elements = count($names);

        for ($i = 0; $i < $elements; $i++) {
            $stmt->bindParam(':'.ltrim($names[$i], ':'), $params[$names[$i]]);
        }

        // Execute statement and return
        $stmt->execute();
        return $stmt;
    }

    /**
     * @param   string      $sql
     * @param   array       $params
     *
     * @return  int
     */
    public function cud($sql, array $params = null) : int
    {
        if (is_null($params)) {
            return $this->execute($sql);
        }
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * @param   string      $sql
     * @param   null|array  $params
     *
     * @return  \PDOStatement
     */
    public function query($sql, array $params = null)
    {
        if (is_null($params)) {
            $sql = trim($sql);
            $stmt = $this->connection->query($sql);
            return $stmt;
        }
        return $this->preparedStmt($sql, $params);
    }

    /**
     * @param   string  $sql
     *
     * @return  int
     */
    private function execute($sql) : int
    {
        $sql = trim($sql);
        $rows = $this->connection->exec($sql);
        return $rows;
    }
}
