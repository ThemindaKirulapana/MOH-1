<?php

require_once("../../core/database/database.class.php");
include("../../core/entity/parent.class.php");


class ParentRepository extends Database
{

    public function save(_Parent $parent)
    {
        try {
            $sql = "INSERT INTO parent (id, name, email, contact, nic, dob, address, family_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmnt = $this->connect()->prepare($sql);
            $stmnt->execute(
                [
                    $parent->getId(),
                    $parent->getName(),
                    $parent->getEmail(),
                    $parent->getContact(),
                    $parent->getNic(),
                    $parent->getDob(),
                    $parent->getAddress(),
                    $parent->getFamily_id()
                ]
            );
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function setFamily($fam_id, $id)
    {
        $sql = "UPDATE parent SET family_id = ? WHERE id = ?";
        $stmnt = $this->connect()->prepare($sql);
        $stmnt->execute([$fam_id, $id]);
    }


    public function findByNic($nic)
    {
        $sql = "SELECT * FROM parent WHERE nic = ? LIMIT 1";
        $stmnt = $this->connect()->prepare($sql);
        $stmnt->execute([$nic]);
        $stmnt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '_Parent');
        $result = $stmnt->fetch();

        return $result;
    }

    public function findUnregistered()
    {
        $sql = "SELECT * FROM parent WHERE nic = ? LIMIT 1";
        $stmnt = $this->connect()->prepare($sql);
        $stmnt->execute();
        $stmnt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '_Parent');
        $result = $stmnt->fetch();

        return $result;
    }

    public function getAllFathers()
    {
        $result = [];
        $sql = "SELECT * FROM parent where type = ?";
        $stmnt = $this->connect()->prepare($sql);
        $stmnt->execute(['FATHER']);
        $result = $stmnt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '_Parent');

        return $result;
    }

    public function getAllMothers()
    {
        $result = [];
        $sql = "SELECT * FROM parent where type = ?";
        $stmnt = $this->connect()->prepare($sql);
        $stmnt->execute(['MOTHER']);
        $result = $stmnt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, '_Parent');

        return $result;
    }
}
