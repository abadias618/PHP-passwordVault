<?php
    include 'conection.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Vault</title>
    <!--Bootstrap.css-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--popper-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <!--fontawsome for social media icons using svg-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="encryptions.css">
</head>

<body>
    <!--top menu-->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/1password-logo.svg/800px-1password-logo.svg.png" width="300" height="30"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="encryptions.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="encryptions_login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo("<h1>Welcome! ".$_SESSION['user']."</h1>") ?>
    <!--table with the contents that you stored-->
    <?php
        try
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = 'SELECT app_name, app_user, app_password, app_date_created, app_extra_info FROM passwords WHERE belongs_to = :username';
            $statement = $db->prepare($query);

            $username_var = $_SESSION['user'];
            $statement->bindValue(':username', $username_var);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                
        }
        catch (PDOException $ex)
        {
            echo 'Error!: ' . $ex->getMessage();
            die();
        }
    ?>
    <div class="container-fluid">
        <h1>Your records</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>App Name</th>
                    <th>User Name</th>
                    <th>Password</th>
                    <th>Date Created</th>
                    <th>Extra Info</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i=0; $i < sizeof($results) ; $i++) { 
                    echo(sizeof($results));
                    echo("<tr>
                    <td>".$results[$i]['app_name']."</td>
                    ");
                    echo("
                    <td>".$results[$i]['app_user']."</td>
                    ");
                    echo("
                    <td>".$results[$i]['app_password']."</td>
                    ");
                    echo("
                    <td>".$results[$i]['app_date_created']."</td>
                    ");
                    echo("
                    <td>".$results[$i]['app_extra_info']."</td>
                    </tr>");
                }?>
                
            </tbody>
        </table>
    </div>
    <div>
        <form action="encryptions_welcome.php" method="POST">
            <h1>Add a new record...</h1> 
            <input type="text" name="appname" placeholder="Name or URL">
            <input type="text" name="appuser" placeholder="Username">
            <input type="text" name="apppassword" placeholder="password">
            <input type="text" name="appinfo" placeholder="Info">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </form>
        <?php
        try
        {
            if(!empty($_POST["appname"]) && !empty($_POST["appuser"]) && !empty($_POST["apppassword"]) && !empty($_POST["appinfo"])) {
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = 'INSERT INTO passwords(belongs_to, app_name, app_user, app_password, app_extra_info) VALUES (:belongs_to, :app_name, :app_user, :app_password, :app_extra_info)';
                $statement = $db->prepare($query);
                $user=$_SESSION['user'];
                $app_name = $_POST["appname"];
                $app_user = $_POST["appuser"];
                $app_password = $_POST["apppassword"];
                $app_extra_info = $_POST["appinfo"];

                $statement->bindValue(':belongs_to', $user );
                $statement->bindValue(':app_name', $app_name);
                $statement->bindValue(':app_user', $app_user);
                $statement->bindValue(':app_password', $app_password);
                $statement->bindValue(':app_extra_info', $app_extra_info);

                $statement->execute();

                if (sizeof($results>0)) {
                    echo '<p style="text-align:center>Record added succesfully!</p>';
                    header("Location: encryptions_welcome.php");
                }
                else {
                    echo '<p style="text-align:center>You haven\'t added records yet!</p>';
                }
                
            }
            else {
                if (isset($_POST["appname"]) && isset($_POST["appuser"]) && isset($_POST["apppassword"])&&  isset($_POST["appinfo"])) {
                echo '<p style="text-align:center">Please Complete all the fields... </p>';
                }
            }

        }
        catch (PDOException $ex)
        {
            echo 'Error!: ' . $ex->getMessage();
            die();
        }
        ?>
        
        
    </div>

    <!--Bottom links-->
    <div class="container-fluid padding">
        <div class="row text-center padding">
            <div class="col-12">
                <h2> Links</h2>
            </div>
            <div class="col-12 social padding">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    <!--bottom info-->
    <footer>
        <div class="container-fluid padding">
            <div class="row text-center">
                <div class="col-md-4">
                    <img src="namelogo.PNG" height="30" width="90">
                    <hr class="light">
                    <p>000-000-0000</p>
                    <p>Email: notanactualemail@gmail.com</p>
                </div>
                <div class="col-md-4">
                    <h5>Address:</h5>
                    <hr class="light">
                    <p>123 State St. </p>
                    <p>Salt Lake City, Utah</p>
                </div>
                <div class="col-md-4">
                    <h5>Second Address:</h5>
                    <hr class="light">
                    <p>1232 North Temple</p>
                    <p>Salt Lake City, Utah</p>
                </div>

            </div>

        </div>

    </footer>

</body>

</html>