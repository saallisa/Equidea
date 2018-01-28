<?php

namespace Equidea\Core\Database;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class Database {

    /**
     * @var \Equidea\Core\Database\Connection
     */
    private $connection;

    /**
     * @param   array   $config
     */
    public function __construct(array $config) {
        $this->connection = new Connection($config);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  \stdClass
     */
    public function select($sql, array $params = [])
    {
        $result = $this->connection->query($sql, $params);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  void
     */
    public function insert($sql, array $params = []) {
        $this->connection->cud($sql, $params);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public function update($sql, array $params = []) : int {
        $this->connection->cud($sql, $params);
    }

    /**
     * @param   string  $sql
     * @param   array   $params
     *
     * @return  int
     */
    public function delete($sql, array $params = []) : int {
        $this->connection->cud($sql, $params);
    }

    /**
     * @return  void
     */
    public function disconnect() {
        $this->connection = null;
    }
}
