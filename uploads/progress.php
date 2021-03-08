<?php
session_start();
$percent = 0;
$data = array();
var_dump($_SESSION);
echo '<br>';
var_dump($_POST);

if(isset($_SESSION['upload_progress_fast']) and is_array($_SESSION['upload_progress_fast'])) {
    $percent = ($_SESSION['upload_progress_fast']['bytes_processed'] * 100 ) / $_SESSION['upload_progress_fast']['content_length'];
    $percent = round($percent,2);
    $data = array(
         'percent' => $percent,
         'content_length' => $_SESSION['upload_progress_fast']['content_length'],
         'bytes_processed' => $_SESSION['upload_progress_fast']['bytes_processed']
  );
}
echo json_encode($data);


?>