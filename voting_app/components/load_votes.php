<?php
    session_start();
    //include("../db_config.php");
	$host = 'localhost';
	$user = 'root';
	$pass = 'mysql';
    $db = 'vote_db';
    
    $conn = mysqli_connect($host, $user, $pass, $db);
	$curs = new mysqli($host, $user, $pass, $db);

    $html = "";
    $sql = "select vote, count(*) as counts from votes where topic_id = ? group by vote";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_GET["ballot"]);
    $stmnt -> execute();
    $stmnt = $stmnt -> get_result();
    $yes_count = $no_count = $maybe_count = 0;

    if (mysqli_num_rows($stmnt) > 0) {
        while($row = mysqli_fetch_assoc($stmnt)) {
            if ($row["vote"] == "yes") {
                $yes_count = $row["counts"];
            }
            if ($row["vote"] == "no") {
                $no_count = $row["counts"];
            }
            if ($row["vote"] == "maybe") {
                $maybe_count = $row["counts"];
            }
        }
    }
    echo "<div class='col-md-4'><h4 class='lg-txt'>$yes_count</h4></div>";
    echo "<div class='col-md-4'><h4 class='lg-txt'>$no_count</h4></div>";
    echo "<div class='col-md-4'><h4 class='lg-txt'>$maybe_count</h4></div>";

?>