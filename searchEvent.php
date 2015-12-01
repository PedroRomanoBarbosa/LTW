<?php
/* Get words */
$var = trim($_POST["query"]);

$words = preg_split("/[\s,~^?'\"]+/", $var);
$headerResult = "?query=";
for($i = 0; $i < count($words); $i++) {
  $headerResult = $headerResult . $words[$i];
  if($i < count($words)-1){
    $headerResult = $headerResult . "+";
  }
}
header('Location: ' . 'index.php' . $headerResult);
?>
