<?php
    include_once("db_config.php");
    $database = new Database();
    $curs = $database -> getConnection();
    session_start();
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == 'POST' && $_POST["pswd"] == $_POST["pswd2"]) {
        $sql = "insert into users(username, email, pswd) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $hash = password_hash($_POST["pswd"], PASSWORD_BCRYPT);
        $stmnt -> bind_param("sss", $_POST["usr"], $_POST["email"], $hash);
        $stmnt -> execute();
        $results = mysqli_affected_rows($curs);

        if ($results) {
            if (!isset($_SESSION["user"])) {
                $_SESSION["user"] = $_POST["usr"];
                header("Location: ./view_ballots.php?".htmlspecialchars(SID));
            }
            else
                echo "You're already logged in as ".$_SESSION["user"];
        }
        else
            $error = "Error: Username or email address already exists.";
    }
    else {
        $error = "Passwords do not match";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stocton Computer Science</title>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--bootstrap css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--main css-->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <!--owl carousel css-->
    <link rel="stylesheet" href="../owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../owlcarousel/assets/owl.theme.default.min.css">
    <!--Bootstrap Fonts & Icons-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
</head>
<body>
    <?php include("./components/nav_menus.php"); ?>
    <section id="particles-js">
        <div class="spacer-1"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="stockton-panel">
                    <h2>Account Creation Form</h2>
                    <p>Having an account lets you submit and vote on ideas for projects or club activities.</p>
                    <form method="post">
                        <input type="text" name="usr" placeholder="Enter a username" required class="form-control">
                        <input type="email" name="email" placeholder="Enter your email" required class="form-control">
                        <input type="password" name="pswd" placeholder="Create a password" required class="form-control">
                        <input type="password" name="pswd2" placeholder="Re-type password" required class="form-control">
                        <input type="submit" value="Register Your Account" class="btn btn-success">
                    </form>            
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </section>
    <script src="../scripts/jquery-min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../owlcarousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../scripts/particles.js"></script>
    <script type="text/javascript" src="../scripts/app.js"></script>
    <script src="../scripts/main.js"></script>
</body>
</html>