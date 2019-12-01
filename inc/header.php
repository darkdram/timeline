<?php
require $_SERVER['DOCUMENT_ROOT'] .  '/system/bootstrap.php';

?><html>
  <head>
    <title>Scheduler</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis.min.css'>
    <link rel='stylesheet' href='/assets/vendor/vis/dist/vis-timeline-graph2d.min.css'>
    <!-- <link rel="stylesheet" href="/assets/vendor/datepicker.min.css"> -->
    <link rel="stylesheet" href="/assets/vendor/datepicker.css">
    <link rel="stylesheet" href="/assets/vendor/vue-multiselect.min.css">
    <link rel='stylesheet' href='/assets/css/main.css' />
  </head>

  <body>
    <? require $_SERVER['DOCUMENT_ROOT'] . '/inc/nav.php'; ?>

    <div class="container-fluid">
      <div class="col-lg-12 col-md-12 col-sm-12">