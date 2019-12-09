<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] .  '/system/controllers/auth.php';
require $_SERVER['DOCUMENT_ROOT'] .  '/system/controllers/projectviewer.php';

$auth = new Auth();

if ( !$auth->isAuth() ) {
	header('Location: /login.php');
	exit();
}


$proj = new ProjectViewer();

$nearestProjects = $proj->nearestProjects();