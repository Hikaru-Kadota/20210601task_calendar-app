<?php

$id = $_POST["id"];
$title = $_POST["title"];
$start = $_POST["start"];
$deadline = $_POST["deadline"];
$deadline_end = $_POST["deadline_end"];
$contact = $_POST["contact"];
$memo = $_POST["memo"];



$write_data = "{$id} {$title} {$start} {$deadline} {$deadline_end} {$contact} {$memo}\n";
$file = fopen('data/schedule.csv', 'a');
flock($file, LOCK_EX);
fwrite($file, $write_data);
flock($file, LOCK_UN);
fclose($file);
header("Location:input.php");
