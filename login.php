 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <div style="background-image: url('backgroundImage.jpg');">
        <div style="font-family: Apple Chancery"> 
            
    </head>
    <header>
            <nav class="navbar navbar-expand-sm bg-warning navbar-transparent fixed-top justify-content-left">

                <span class="navbar-brand" href ="lakeroyaluniversity.com">
                    <img src="LakeRoyal.png" alt="Logo" style="width:50px;"> 
                </span>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="academicCalendar.php">Academic Calender</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="searchMasterSchedule.php">Master Schedule</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="viewCatalog.php">Course Catalog</a>
                    </li>
                    
                    <li class="nav-item" >
                        <a class="nav-link " href="login.php">Log In</a>
                    </li>
                </ul>
            </nav>
        
        </header> 
        <br>
        <br>
        <br>
        <br>

    <body class="backgroundImage"
    div style="background-image: url('backgroundImage.jpg');">
        <h1 class="title" align="center"><strong>Lake Royal University</strong></h1>

        <div class="container" style="width:450px">
            <table class="container">
                <tr>
                    <th><h2 style="text-align:center">Login</h2></th>
                </tr>
                <tr>
                    <td>
                        <p>Please use your university email and password to login.</p>
                            <form action="/login.php" method="post">
                                <div style="color:red">
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group" align="center">
                                    <label>Email</label>
                                        <input type="text" name="email" class="form-control" required>
                                </div>    
                                <div class="form-group" align="center">
                                    <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group" align="center">
                                    <input type="submit" class="btn btn-primary" value="Log In">
                                </div>
                                <div class="form-group" align="center">
                                <p style="color: white"><strong>Authorized use only</strong></p>
                                </div>
                            </form>
                    </td>
                </tr>
            </table>
        </div>
        
    </body>
</html>