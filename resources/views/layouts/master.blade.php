<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style type="text/css">
    body {
        background: #eee !important;
    }

    .wrapper {
        margin-top: 80px;
      margin-bottom: 80px;
    }

    .form-signin {
      max-width: 380px;
      padding: 15px 35px 45px;
      margin: 0 auto;
      background-color: #fff;
      border: 1px solid rgba(0,0,0,0.1);

      .form-signin-heading,
        .checkbox {
          margin-bottom: 30px;
        }

    .checkbox {
      font-weight: normal;
    }

    .form-control {
      position: relative;
      font-size: 16px;
      height: auto;
      padding: 10px;
        &:focus {
          z-index: 2;
        }
    }

    input[type="text"] {
      margin-bottom: -1px;
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }

    input[type="password"] {
      margin-bottom: 20px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
}

    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
