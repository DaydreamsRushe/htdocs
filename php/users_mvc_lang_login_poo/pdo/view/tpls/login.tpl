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
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
    </style>
</head>
<body class="container-fluid">
    <header class="mx-2">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <h3><a class="navbar-brand">{{::logo::}}</a></h3>
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
    
    <div class="login-container">
        <h2 class="text-center mb-4">{{::login_title::}}</h2>
        <form method="post" action="../controller/app_pdo.php">
            <div class="mb-3">
                <label class="form-label">{{::label_usuario::}}</label>
                <input type="text" class="form-control {{::class_error::}}" name="usuario" value="{{::usuario::}}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{::label_pwd::}}</label>
                <input type="password" class="form-control {{::class_error::}}" name="pwd" required>
            </div>
            <input type="hidden" name="action" value="Login">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">{{::login_button::}}</button>
            </div>
            <div class="text-center mt-3">
                <a href="?action=register">{{::register_link::}}</a>
            </div>
            {{::mensaje_error::}}
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 