<?php
function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };
$solico = ['madrrre'];

while (count($solico) < 15){
  array_push($solico,"malo");
}
print_r($solico);

?>