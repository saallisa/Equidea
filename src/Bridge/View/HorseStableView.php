<?php

namespace Equidea\Bridge\View;

use Equidea\Core\Database\Database;
use Equidea\Engine\Entity\HorseEntity;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class HorseStableView {

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
     * @param   int $owner
     * @param   int $start
     * @param   int $end
     *
     * @return  array
     */
    public function getAllByOwner(int $owner, int $start, int $end) : array
    {
        // Selects all horses of a player
        $sql =  'SELECT * FROM `horse_stable_view` WHERE `owner` = :owner
                LIMIT ' . $start . ',' . $end;

        // Retrieve the horses as an array from the database
        return $this->database->select($sql, ['owner' => $owner]);
    }
}
