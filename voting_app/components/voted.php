<?php
    include_once("./db_config.php");
    $database = new Database();
    $curs = $database -> getConnection();
    $sql = "select admin, status from topics where id = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_GET["ballot"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
?>
<div class="review">
    
        <?php
            $row = mysqli_fetch_assoc($results);
            if ($row["admin"] == $_SERVER["REMOTE_ADDR"]) {
                echo "<div class='row'><div class='col-md-6'>";
                echo "<h3>Thanks for Voting ".$_SERVER["REMOTE_ADDR"]."</h3></div>";
                echo "<div class='col-md-6 text-right'>";
                if ($row["status"] == "Open")
                    echo "<input type='submit' name='change-status' value='Close Ballot' class='btn btn-danger'></div></div>";
                else
                    echo "<input type='submit' name='change-status' value='Open Ballot' class='btn btn-success'></div></div>";
            }

            else
                echo "<h3>Thanks for Voting ".$_SERVER["REMOTE_ADDR"]."</h3>";
        ?>
</div>