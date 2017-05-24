<?php

namespace App\Models;

use \PDO;

class QueueModel extends AbstractModel
{
    public function getQueue($type = null)
    {
        try {
            $sql = '
                SELECT * FROM `queue`
                WHERE queuedDate >= CURDATE()
            ';

            if (!is_null($type)) {
                $sql .= ' AND `type` = :type';
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
            } else {
                $stmt = $this->db->prepare($sql);
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function postQueue($firstName = null, $lastName = null, $organization = null, $type, $service)
    {
        try {
            $sql = '
                INSERT INTO `queue` 
                    (`firstName`, `lastName`, `organization`, `type`, `service`, `queuedDate`)
                VALUES
                    (:firstName, :lastName, :organization, :type, :service, NOW());
            ';
            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':firstName', $firstName, \PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $lastName, \PDO::PARAM_STR);
            $stmt->bindValue(':organization', $organization, \PDO::PARAM_STR);
            $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
            $stmt->bindValue(':service', $service, \PDO::PARAM_STR);
            $stmt->execute();

            return ($stmt->rowCount() > 0);
        } catch (\PDOException $e) {
            return false;
        }
    }

}