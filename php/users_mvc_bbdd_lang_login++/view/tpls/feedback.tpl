<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{::title::}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        h2{font-family: 'Roboto', sans-serif}
        .error{border:2px solid red!important;}
    </style>
</head>
<body>
    <header class="navbar-light bg-light">
        <nav class="mx-5 navbar navbar-light bg-light justify-content-between">
            <h3 class="me-5"><a class="navbar-brand">{{::logo::}}</a></h3>
            <form class="form-inline my-2 mx-2" method="GET">
                <label class="mr-sm-2" for="inlineFormCustomSelectPref">{{::cambiar_idioma::}}</label>
                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="lang">
                    <option selected>{{::opcion1::}}</option>
                    <option value="cast">{{::opcion2::}}</option>
                    <option value="cat">{{::opcion3::}}</option>
                </select>
                <button type="submit" class="btn btn-primary">{{::cambiar::}}</button>
            </form>
        </nav>
    </header>
    <div class="container-fluid m-5">
        <section>
            <h3>{{::title::}}</h3>
            <p>{{::registre_1::}} {{::usuario::}}.</p>
            <p>{{::registre_2::}} {{::email::}}</p>
            <div>
                <a class="btn btn-primary" href="../controller/app.php">{{::tornar::}}</a>
            </div>
        </section>

        <h3>{{::tabla::}}</h3>
        <table class="table">
            <tr>
                <td>ID</td>
                <td>{{::usuari::}}</td>
                <td>{{::mail::}}</td>
                <td>{{::password::}}</td>
            </tr>
            {{::div::}}
        </table>
        <div class="w3-center w3-margin-top">
            <a class="btn btn-primary" href="../controller/app.php">{{::tornar::}}</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  