<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="booking-form">
            <form id="booking-form" method="POST" action="{{ route('login') }}">
                @csrf
                <h2>INICIAR SESIÓN</h2>
                <div class="form-group form-input">
                    <input type="text" name="matricula" id="matricula" value="" required/>
                    <label for="matricula" class="form-label">Matricula</label>
                </div>
                <div class="form-group form-input">
                    <input type="password" name="password" id="password" value="" required />
                    <label for="password" class="form-label">Contraseña</label>
                </div>
                @if($errors->has('matricula'))
                    <div class="alert alert-danger">
                        {{ $errors->first('matricula') }}
                    </div>
                @endif
                <div class="form-submit">
                    <input type="submit" value="Ingresar" class="submit" id="submit" name="submit" />
                </div>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>