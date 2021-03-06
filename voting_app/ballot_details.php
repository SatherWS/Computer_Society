<?php
    session_start();

    include_once("db_config.php");
    $database = new Database();
    $curs = $database->getConnection();

    $sql = "select * from topics where id = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_GET["ballot"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();

    // cast vote to selected poll if vote btn is clicked
    if ( $_POST["vote"]) {
        $sql = "insert into votes(topic_id, vote, client) values (?, ?, ?)";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("sss", $_GET["ballot"], $_POST["vote"], $_POST["usr"]);
        $stmnt -> execute();
    }
    
    if ($_POST["change-status"]) {
      if ($_POST["change-status"] == "Close Ballot")  
        $sql = "update topics set status = 'Closed' where id = ?";
      else
        $sql = "update topics set status = 'Open' where id = ?";
      $stmnt = mysqli_prepare($curs, $sql);
      $stmnt -> bind_param("s", $_GET["ballot"]);
      $stmnt -> execute();
    }
    
    function hasVoted($curs, $voted) {
        $sql = "select id from votes where client = ? and topic_id = ?";
        $stmnt = mysqli_prepare($curs, $sql);
        $stmnt -> bind_param("ss", $voted, $_GET["ballot"]);
        $stmnt -> execute();
        $results = $stmnt -> get_result();
        if (mysqli_num_rows($results) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    if (hasVoted($curs, $_SESSION["user"]))
        header("Location: ./realtime_ballot.php?ballot=".$_GET["ballot"]);

    // data for bar graph visual
    $sql2 = "select vote, count(*) as counts from votes where topic_id = ? group by vote";
    $stmnt2 = mysqli_prepare($curs, $sql2);
    $stmnt2 -> bind_param("s", $_GET["ballot"]);
    $stmnt2 -> execute();
    $results2 = $stmnt2 -> get_result();
    $yes_count = $no_count = $maybe_count = 0;

    if (mysqli_num_rows($results2) > 0) {
        while($row = mysqli_fetch_assoc($results2)) {
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
        <div class="detail-panel">
            <div class="row">
            <?php
                while ($row = mysqli_fetch_assoc($results)) {
                    echo "<div class='col-md-6'><h1>".$row["topic"]."</h1>";
                    echo "<h3>".$row["date_created"]."</h3></div>";
                    echo "<div class='col-md-6 text-right'></div>";
                    //echo "<h3><span class='badge badge-pill badge-success'>".$row["status"]."</span></h3></div>";
                }
            ?>
            </div>
            <form method="post">
                <h3>Your Username: <?php echo $_SESSION['user'];?></h3>
                <input type='hidden' value='<?php echo $_SESSION['user'];?>' name='usr' class='form-control' placeholder='Enter Your Name'>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Select Your Vote:</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" name="vote" value="yes" class="btn btn-success">Yes</button>
                        <button type="submit" name="vote" value="no" class="btn btn-success">No</button>
                        <button type="submit" name="vote" value="maybe" class="btn btn-success">Maybe</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="chart-container">
            <canvas style="position: relative; width: 600px; height: 460px;" id="myChart"></canvas>
        </div>
    </section>
    
    <script src="../scripts/jquery-min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../owlcarousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../scripts/particles.js"></script>
    <script type="text/javascript" src="../scripts/app.js"></script>
    <script src="../scripts/main.js"></script>
    <!--Graph Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',
            
            // The data for our dataset
            data: {
                labels: ['Yes', 'No', 'Maybe'],
                datasets: [{
                    data: [<?php echo $yes_count.",".$no_count.",". $maybe_count;?>],
                    backgroundColor: [
                        '#2b9eb3',
                        '#f8333c',
                        '#28a745'
                    ],
                    borderColor: '#fff'
                }]
            },
            // Configuration options go here
            options: {
                maintainAspectRatio:false
                ,scales: {
                    yAxes: [{
                    gridLines: {
                            color:"#222326"
                    },  
                    ticks: {
                            beginAtZero: true,
                            fontColor: "white",
                            fontSize: 16
                        }
                    }]
                    ,xAxes: [{
                        gridLines: {
                            color:"#222326"
                        },
                        ticks: {
                            fontColor: "white",
                            fontSize: 24,
                        }
                    }]
                }
                ,legend: {
                    display: false,
                    labels: {
                        fontColor: "white",
                        fontSize: 18,
                    }
                },
                tooltips: {
                    callbacks: {
                    label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                            }
                    }
                }    
            }
        });

        // Prevent duplicate data on form refresh
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>