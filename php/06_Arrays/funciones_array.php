<?php
  function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };

  $cantantes = ['Josele Santiago', 'Justin Sullivan', 'Chrissie Hynde'];
  $numeros = [1,2,3,4,5];
  pDump($numeros);

  //Ordenar

  sort($numeros);
  pDump($numeros);

  pDump($cantantes);

  sort($cantantes);
  pDump($cantantes);

  //Añadir elementos array
  $cantantes[] = "Natos";
  pDump($cantantes);
  array_push($cantantes, "wawooo");
  pDump($cantantes);
  $cantantes[] = "alegria";
  pDump($cantantes);

  //eliminar elementos
  array_pop($cantantes);
  pDump($cantantes);

  unset($cantantes[2]);
  pDump($cantantes);

  //aleatorio
  $indice = array_rand($cantantes);
  echo $cantantes[$indice];

  //Dar la vuelta
  pDump(array_reverse($cantantes));

  //Clonar un array
  $original = [1,2,3,4];
  $copy = array_merge([], $original);
  pDump($original);
  pDump($copy);

  $animales =["perro"=>"bruce", "snep" =>"cute"];
  if (array_key_exists("perro",$animales)){
    echo "tengo un perro llamado $animales[perro]";
  }
  if (in_array("perro",$animales)){
    pDump($animales);
    echo "tengo un $animales[perro] de mascota";
  }
  $prueba1 = json_encode($animales);
  echo "<br><hr>";
  pDump($prueba1);
  echo "<br><hr>";
  echo $prueba1;
  echo "<br><hr>";
  $prueba2 =json_encode($prueba1);
  pDump($prueba2);
  echo "<br><hr>";

   foreach ($animales as $key => $value) {
    echo "$key = $value<br>";
  } 

  $keys =['cielo','tierra','mar'];
  $values =['azul','verde','turquesa'];
  $new_array = array_combine($keys,$values);
  pDump($new_array);
  echo "<br><hr>";

  function alCubo($numero){
    return $numero * $numero * $numero;
  }

  $a = [1,2,3,4,5,6];
  $result = array_map('alCubo',$a);
  pDump($result);
  echo "<br><hr>";

  range(1,10);
  $result2 = array_map(function ($n){
    return ($n*$n*$n);
  },$a);
  pDump($result2);

  echo "<br><hr>";
  $result3 = array_map(fn ($n)=>$n * $n *$n,range($a[1],$a[3]));

  pDump($result3);
  echo "<br><hr>";

  $employeeNames = ['john','mark','lisa'];
  $employeeEmails = ['john@example.com','mark@example.com','lisa@example.com','uu@oo.com'];
  $res = array_map(null, $employeeNames, $employeeEmails);
  pDump($res);
  echo '<br>';

  $agenda =[
  ['nombre'=>"Pepe", "email" => 'email@example.com'],
  ['nombre'=>"Pepon", "email" => 'otro@example.com'],
  ['nombre'=>"Jose", "email" => 'yotro@example.com'],
  'nombre' => 'antonio'
  ];
  
  
  
  ?>