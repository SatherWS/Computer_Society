<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        include_once("../db_config.php");
        $db = new Database();
        $curs = $db -> getConnection();

        $sql = "select username, pswd from users where username = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("s", $_POST["usr"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        $row = mysqli_fetch_assoc($results);

        if (password_verify($_POST["pswd"], $row["pswd"])) {
            $_SESSION["user"] = $_POST["usr"];
            echo "correct";
            header("Location: ../view_ballots.php");
        }
        else {
            header("Location: ../login.php");
            echo "Incorrect creds";
        }
    }

?>