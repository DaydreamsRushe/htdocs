<?php
$lang = "";
if(isset($_GET['lang'])){
  if($_GET['lang'] == "cast")
    $lang = "Variable escrita en Castellano";
   if($_GET['lang'] == "ca")
    $lang = "Variable escrita en Catala";
}
echo "<br>";
echo $lang;
echo "<br>";
?>

<a href="?lang=cast">es</a> || <a href="?lang=ca">cat</a>