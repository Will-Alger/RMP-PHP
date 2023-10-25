<?php
class SQLiteDB
{
    private $db;

    public function __construct($filename)
    {
        $this->db = new PDO('sqlite:' . $filename);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    private function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchOneAsJson($sql, $params = [])
    {
        return json_encode($this->fetchOne($sql, $params));
    }

    public function fetchAllAsJson($sql, $params = [])
    {
        return json_encode($this->fetchAll($sql, $params));
    }

    public function __destruct()
    {
        $this->db = null;
    }
}

require_once 'sql/queries.php';

class rmpDB extends SQLiteDB
{
    public function getProfessorByLegacyId($legacyId)
    {
        $sql = "SELECT * FROM teachers WHERE legacyId = :legacyId";
        return $this->fetchOne($sql, ['legacyId' => $legacyId]);
    }

    public function getUniversityByLegacyId($legacyId)
    {
        $sql = "SELECT * FROM schools WHERE legacyId = :legacyId";
        return $this->fetchOne($sql, ['legacyId' => $legacyId]);
    }

    public function getProfessorsByDepartment($department)
    {
        $sql = "SELECT * FROM teachers WHERE department = :department";
        return $this->fetchAll($sql, ['department' => $department]);
    }

    public function getUniversitiesByState($state)
    {
        $sql = "SELECT * FROM schools WHERE state = :state";
        return $this->fetchAll($sql, ['state' => $state]);
    }

    public function getSchoolData($sql, $schoolId, $department = null)
    {
        $params = ['schoolId' => $schoolId];
        if ($department !== null) {
            $sql .= " AND department = :department AND avgRating != 0";
            $params['department'] = $department;
        }
        return $this->fetchOne($sql, $params);
    }

    public function aggregateSchoolData($db, $schoolData, $scope)
    {
        global $aggregateSchoolDataSql;

        if ($scope == "state") {
            $state = $schoolData['state'];
            $aggregateSchoolDataSql .= " WHERE state = :state";
            return $db->fetchOne($aggregateSchoolDataSql, ['state' => $state]);
        } else if ($scope == "platform") {
            return $db->fetchOne($aggregateSchoolDataSql);
        }
    }
}
