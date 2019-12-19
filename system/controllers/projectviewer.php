<?php

class ProjectViewer
{
    public $db;

    function __construct($dbh)
    {
        $this->db = $dbh;
        // var_dump($dbh);
    }

    function nearestProjects()
    {
        $query = "SELECT * FROM `timetable` WHERE type = 'background' AND ( end BETWEEN 'CURRENT_DATE()' AND DATE_ADD( 'CURRENT_DATE()' , INTERVAL 10 DAY ) )";
        $res = $this->db->query($query);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

}
