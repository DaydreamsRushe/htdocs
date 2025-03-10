<?php
session_start();
if(!isset($_SESSION['nomas'])){
  $_SESSION['nomas'] = 5;
}
echo '<form class="form-inline">
<label >Escribe un elemento a buscar</label>
      <input type="number" name="sumarito"/>
      <button type="submit" value="Buscar">Buscar</button>
      </form>';

if(isset($_GET['sumarito'])){
  if($_GET['sumarito'] == 1){
    $_SESSION['nomas']++;
  }elseif($_GET['sumarito'] == 0){
    $_SESSION['nomas']--;
  }

  echo $_SESSION['nomas'];
  

}
?>