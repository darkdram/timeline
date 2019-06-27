<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Respect\Validation\Validator as v;

$data = file_get_contents('php://input');

$json = json_decode( $data, true );

//default dates
$dates = array(
  'real' => array(
    'admittance' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'work' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'report' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    )
  ),
  'contract' => array(
    'admittance' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'work' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    ),
    'report' => array(
      'start' => '0000-00-00',
      'end'   => '0000-00-00'
    )
  )
);

$errors = array();

if ( isset($json['times']) ) {
  $_times = $json['times'];

  foreach ($_times as $time_type => $time_times) {
    //$time_type = real, contract
    foreach ($time_times as $time_sub_type => $new_times) {
      // $time_sub_type = admittance, work, report
      echo '$dates[' . $time_type . '][' . $time_sub_type. ']' . PHP_EOL;

      if ( isset( $dates[$time_type][$time_sub_type] ) ) {
        foreach ($new_times as $tt => $tv) {
          //$tt - start(0), end(1)
          if ( v::date('Y-m-d')->validate( $tv ) ) {
            $idx = $tt == 0  ? 'start' : 'end';
            $dates[$time_type][$time_sub_type][ $idx ] = $tv;
          }
        }
      }
    }
  }
}

var_dump($json);

var_dump($dates);


