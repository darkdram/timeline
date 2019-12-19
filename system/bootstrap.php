<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/system/controllers/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/system/controllers/projectviewer.php';

$auth = new Auth();

if (!$auth->isAuth()) {
    header('Location: /login.php');
    exit();
}

// var_dump($dbh);
$proj = new ProjectViewer($dbh);

$nearestProjects = $proj->nearestProjects();
