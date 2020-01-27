<?php
    include 'conection.php';
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
    <div>
        <form action="encryptions_register.php" method="POST">
            <h1>Register...</h1>    
            <h1>Username</h1>
            <input type="text" name="username"><br>
            <h1>Password</h1>
            <input type="password" name="password"><br>
            <h1>E-mail</h1>
            <input type="text" name="email"><br>
            <h1>Security Question 1</h1>
            <input type="text" name="sec1" placeholder="Question"><input type="text" name="ans1"placeholder="Answer"><br>
            <h1>Security Question 2</h1>
            <input type="text" name="sec2" placeholder="Question"><input type="text" name="ans2"placeholder="Answer"><br>
            <h1>Security Question 3</h1>
            <input type="text" name="sec3" placeholder="Question"><input type="text" name="ans3"placeholder="Answer"><br>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </form>
        <?php
        try
        {
            if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["sec1"]) && !empty($_POST["sec2"]) && !empty($_POST["sec3"]) && ($_POST["ans1"]) && !empty($_POST["ans2"]) && !empty($_POST["ans3"])) {
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = 'INSERT INTO main_user (user_name, password, user_email, sec1, sec2, sec3, ans1, ans2, ans3) VALUES (:username, :password, :email, :sec1, :sec2, :sec3, :ans1, :ans2, :ans3)';
                $statement = $db->prepare($query);

                $username_var = $_POST["username"];
                $password_var = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $email = $_POST["email"];
                $sec1 = $_POST["sec1"];
                $sec2 = $_POST["sec2"];
                $sec3 = $_POST["sec3"];
                $ans1 = $_POST["ans1"];
                $ans2 = $_POST["ans2"];
                $ans3 = $_POST["ans3"];

                $statement->bindValue(':password', $password_var);
                $statement->bindValue(':username', $username_var);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':sec1', $sec1);
                $statement->bindValue(':sec2', $sec2);
                $statement->bindValue(':sec3', $sec3);
                $statement->bindValue(':ans1', $ans1);
                $statement->bindValue(':ans2', $ans2);
                $statement->bindValue(':ans3', $ans3);
                $statement->execute();

                echo '<p>Registration is complete. Please login <a href="encryptions_login.php">Here</a> </p>';
            }
            else {
                if (isset($_POST["username"]) && isset($_POST["password"])) {
                echo '<p style="text-align:center">Registration is incomplete. Please Check your answers </p>';
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