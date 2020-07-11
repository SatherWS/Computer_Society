<?php
    session_start();
    include_once("db_config.php");
    //include("./components/load_votes.php");
    $database = new Database();
    //$allvotes = new DataGroups();
    $curs = $database->getConnection();

    $sql = "select * from topics where id = ?";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("s", $_GET["ballot"]);
    $stmnt -> execute();
    $results = $stmnt -> get_result();
    
    if ($_POST["change-status"]) {
      if ($_POST["change-status"] == "Close Ballot")  
        $sql = "update topics set status = 'Closed' where id = ?";
      else
        $sql = "update topics set status = 'Open' where id = ?";
      $stmnt = mysqli_prepare($curs, $sql);
      $stmnt -> bind_param("s", $_GET["ballot"]);
      $stmnt -> execute();
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- realtime vote rendering using ajax -->
  <script>
	function loaddata()
    {
	   $.ajax({
           url: './components/load_votes.php?ballot=<?php echo $_GET["ballot"];?>',
           success: function (response) {
                $('.display_info' ).html(response);
           }
	   });
	   // recursive call to set timeout function
	   setTimeout(loaddata, 2000);
	}
    loaddata();
</script>

</head>
<body>
    <?php include("./components/nav_menus.php"); ?>
    <section id="particles-js">
        
        <div class="detail-panel">
            <form method="post">
                <div class="review">
                    <div class="row">
                    <?php
                        while ($row = mysqli_fetch_assoc($results)) {
                            echo "<div class='col-md-6'><h1>".$row["topic"]."</h1>";
                            echo "<h3>".$row["date_created"]."</h3></div>";
                            echo "<div class='col-md-6 text-right'>";
                            if ($row['status'] == "Open")
                                echo "<h3><span class='badge badge-pill badge-success'>".$row["status"]."</span></h3></div></div>";
                            if ($row['status'] == "Closed")
                                echo "<h3><span class='badge badge-pill badge-danger'>".$row["status"]."</span></h3></div></div>";

                            if ($row["admin"] == $_SESSION["user"]) {
                                echo "<div class='row'><div class='col-md-6'>";
                                echo "<h3>Thanks for Voting ".$_SESSION["user"]."</h3></div>";
                                echo "<div class='col-md-6 text-right'>";
                                if ($row["status"] == "Open")
                                    echo "<input type='submit' name='change-status' value='Close Ballot' class='btn btn-danger'></div></div>";
                                else
                                    echo "<input type='submit' name='change-status' value='Open Ballot' class='btn btn-success'></div></div>";
                            }
                            else {
                                echo "<h3>Thanks for Voting ".$_SESSION["user"]."</h3>";
                            }
                        }
                    ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="detail-panel">
            <div class="row text-center">
                <div class="col-md-4 text-success">
                    <h4>Yes Votes</h4>
                </div>
                <div class="col-md-4 text-danger">
                    <h4>No Votes</h4>
                </div>
                <div class="col-md-4 text-warning">
                    <h4>Maybe Votes</h4>
                </div>
            </div>
            <section class='display_info row text-center'>
            
            </section>
        </div>
        <div class="detail-panel">
            <a href="./view_ballots.php" class="btn btn-success">Go Back</a>
        </div>
        <!--
        <div class="chart-container">
            <canvas style="position: relative; width: 600px; height: 460px;" id="myChart"></canvas>
        </div>
        -->
    </section>
    
    <script src="../scripts/jquery-min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../owlcarousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../scripts/particles.js"></script>
    <script type="text/javascript" src="../scripts/app.js"></script>
    <script src="../scripts/main.js"></script>
    <!--Graph Scripts
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var counts = document.getElementsByClassName(".display_info");
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',
            
            // The data for our dataset
            data: {
                labels: ['Yes', 'No', 'Maybe'],
                datasets: [{
                    data: [],
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

    </script>
    -->
</body>
</html>