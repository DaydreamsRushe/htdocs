<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- <title></title> -->
    <title>{{::title::}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        h2{font-family: 'Roboto', sans-serif}
    .error{border:2px solid red!important;}

    </style>
</head>
        <body>
            <header style:"width:100%" class="navbar-light bg-light">
                  <nav class="mx-5 navbar navbar-light bg-light justify-content-between">
                        <h3 style="width:70%:float:left" class="me-5"><a class="navbar-brand">{{::logo::}}</a></h3>
       <div style="width:30%:float:right">
                              <label for="inlineFormCustomSelectPref">{{::cambiar_idioma::}}</label>
                              <a href="?lang=cat&canvi=true">Català</a> || <a href="?lang=cast&canvi=true">Castellano</a>
                              </div>
                  </nav>
            </header>
		<div class="container-fluid m-5">
      
			<section>	
				<h3 class="">{{::title::}}</h3>	
				<p>{{::registre_1::}} {{::usuario::}}.</p>
				<p>{{::registre_2::}} {{::email::}} </p>
				<div class="">
				<a class="btn btn-primary" href="app.php">{{::tornar::}}</a>
				</div>
			</section>

			<h3 class=""> {{::tabla::}}</h3>
			<table class="table">
					<tr"><td>ID</td><td>{{::usuari::}}</td><td>{{::mail::}}</td><td>{{::password::}}</td></tr>  
			
             
             {{::div::}}
             </table>
		<div class="w3-center w3-margin-top">
		    <a class="btn btn-primary" href="app.php">{{::tornar::}}</a>
        </div>

            <nav>
				<a href="?lang=cat&canvi=true">Català</a> || <a href="?lang=cast&canvi=true">Castellano</a>
			</nav>	
		</div>	
	</body>
	</html>  