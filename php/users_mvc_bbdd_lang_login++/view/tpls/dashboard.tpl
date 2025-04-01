<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{::title::}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        h2{font-family: 'Roboto', sans-serif}
        .welcome-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="container-fluid">
    <header class="mx-2">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <h3><a class="navbar-brand">{{::logo::}}</a></h3>
            <div>
                <span class="me-3">{{::welcome::}} {{::usuario::}}</span>
                <form class="form-inline my-2 mx-2" method="GET">
                    <label class="mr-sm-2" for="inlineFormCustomSelectPref">{{::cambiar_idioma::}}</label>
                    <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="lang">
                        <option selected>{{::opcion1::}}</option>
                        <option value="cast">{{::opcion2::}}</option>
                        <option value="cat">{{::opcion3::}}</option>
                    </select>
                    <button type="submit" class="btn btn-primary">{{::cambiar::}}</button>
                </form>
            </div>
        </nav>
    </header>
    
    <div class="welcome-container">
        <div class="user-info">
            <h4>{{::dashboard_title::}}</h4>
            <p>{{::user_id::}}: {{::id::}}</p>
            <p>{{::user_name::}}: {{::usuario::}}</p>
            <p>{{::user_email::}}: {{::email::}}</p>
        </div>
        <div class="text-center">
            <a href="?action=logout" class="btn btn-danger">{{::logout_button::}}</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 