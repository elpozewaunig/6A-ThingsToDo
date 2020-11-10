<?php

function jsonify_conferences($input, $user) {
  
  include_once 'get_subjects.php';
  include_once 'constants.php'; // contains array of all subjects
  
  if ($user !== "all") {
    $user_subjects = explode(', ', file_get_contents("data/users/$user"));
    $subjects = get_subjects($user_subjects); // resolves groups to individual subjects
  }
  else {
    $subjects = SUBJECTS; // subjects as defined in constants.php
  }
  
  $json = "";
  
  foreach($input as $l) {
    if($l !== PHP_EOL) {
      $json = $json.build_event($l, $subjects);
    }
  }
  
  $json = trim($json, ', ');
  
  return $json;
  
}

function build_event($line, $subjects) {
  
  $output = "{";
  
  $cell_array = str_getcsv($line,"|");
  
  if(in_array( trim($cell_array[0]), $subjects ))  { // only show item if subject is enabled
      
    for ($i = 0; $i < count($cell_array); $i++) { // cycles through every element of one line
      
      if($i == 0) {
        $output = $output."title: '".$cell_array[$i]." - ".$cell_array[1]."', ";
        $output = $output."classNames: ['subject', '".$cell_array[$i]."'], ";
      }
      elseif($i == 2) {
        if(trim($cell_array[$i]) !== "") {
          $output = $output."url: '".$cell_array[$i]."', ";
        }
      }
      elseif($i == 3) {
        $output = $output."start: '".convert_date($cell_array[$i])."', ";
      }
      elseif($i == 4) {
        if(trim($cell_array[$i]) == '#') {
          $output = $output."end: '".convert_date(add_to_date($cell_array[3], "+".lesson_length))."'"; // lesson length is defined in config.txt
        }
        else {
          $output = $output."end: '".convert_date($cell_array[$i])."'";
        }
      }
      
    }
  }
  
  $output = $output."}, ";
  
  return $output;
}

function convert_date($datestring) {
  $timestamp = date_timestamp_get( date_create_from_format("d.m.Y, H:i", trim($datestring)) );
  $converted_date = date("Y-m-d", $timestamp)."T".date("H:i:s", $timestamp);
  
  return $converted_date;
}

function add_to_date($datestring, $addition) {
  $timestamp = date_timestamp_get( date_create_from_format("d.m.Y, H:i", trim($datestring)) );
  $new_timestamp = strtotime($addition, $timestamp);
  
  $date = date("d.m.Y, H:i", $new_timestamp);
  
  return $date;
}

?>