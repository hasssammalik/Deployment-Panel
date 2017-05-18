<?php
echo "---------------------------------------------------------------- </br>";
echo "Deleting </br>Stack: ".$_POST['stack']."</br> Domain: ".$_POST['domain'];
echo "</br>---------------------------------------------------------------- </br>";

$download = shell_exec('aws s3 cp s3://env-feature/Backend/BackEnd-stripDown.sh ./');
$cmd = 'sh ./BackEnd-stripDown.sh '.$_POST['stack']." ".$_POST['domain'].".";
//$cmd = 'sh ./stripDown.sh';
echo "Executing: ".$cmd;
$output =  exec($cmd);
echo "<br>Stack delete: ". $output;
header( 'Location: index.php' );
