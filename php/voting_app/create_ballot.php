<?php
  include_once("db_config.php");
  $database = new Database();
  $curs = $database->getConnection();
    
  if ($curs->connect_error) {
    die("Connection failed: " . $curs->connect_error);
  }
  // add voting topic to table of polls
  if ($_POST["topic"] && $_POST["admin"]) {
    $sql = "insert into topics(admin, topic) values (?, ?)";
    $stmnt = mysqli_prepare($curs, $sql);
    $stmnt -> bind_param("ss", $_POST['admin'], $_POST['topic']);
    $stmnt -> execute();
    header("Location: ./view_ballots.php");
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
  <link rel="stylesheet" href="../../css/main.css">
  <link rel="stylesheet" href="../../css/responsive.css">
  <!--owl carousel css-->
  <link rel="stylesheet" href="../../owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../../owlcarousel/assets/owl.theme.default.min.css">
  <!--Bootstrap Fonts & Icons-->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <!--google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
</head>
<body>
  <!--desktop/tablet nav-->
  <nav id="menu">
      <img class="logo" src="../../img/stockton_seal.png" alt="main">
      <div class="nav-list">
        <ul>
          <li class="nav-item">
              <a href="#about">
                <i class="fa fa-laptop"> <span>About Us</span></i>
              </a>
            </li>
            <li class="nav-item">
                <a href="#board">
                  <i class="fa fa-users"> <span>Board Members</span></i>
                </a>
              </li>
            <li class="nav-item">
              <a href="#contact">
                <i class="fa fa-envelope-o"> <span>Contact Info</span></i>
              </a>
            </li>
            <li class="nav-item">
              <a href="/php/voting_app/" onclick="alert('Feature coming soon')">
                <i class="fa fa-pencil-square-o"> <span>Create a Ballot</span></i>
              </a>
            </li>
            <li class="nav-item">
                <a href="./view_ballots.php">
                  <i class="fa fa-bar-chart"> <span>View Ballots</span></i>
                </a>
            </li>
          </ul> 
          <div class="someLine"></div>
        </div>
    </nav>
    <!--mobile nav-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">        
          <img class="logo" src="img/stockton_seal.png" alt="main">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="#about">
                  <i class="fa fa-file-code-o"> <span>About us</span></i>
                </a>
              </li>
              <li class="nav-item">
                  <a href="#board" data-toggle="collapse" data-target=".navbar-collapse.in">
                    <i class="fa fa-users"> <span>Board members</span></i>
                  </a>
                </li>
              <li class="nav-item">
                <a href="#contact">
                  <i class="fa fa-envelope-o"> <span>Contact us</span></i>
                </a>
              </li>
              <li class="nav-item">
                <a href="#">
                  <i class="fa fa-pencil-square-o"> <span>Create a Ballot</span></i>
                </a>
              </li>
              <li class="nav-item">
                  <a href="./view_ballots.php">
                    <i class="fa fa-bar-chart"> <span>View Ballots</span></i>
                  </a>
              </li>
          </ul>
        </div>
    </nav>
    <section id="particles-js">
      <form method="post" class="app" id="post-journal">
        <div class="ballot-panel">
            <h1>New Ballot Form</h1>
            <h3>Username: <?php echo $_SERVER['REMOTE_ADDR'];?></h3>
            <br>
            <input type="text" name="topic" placeholder="Describe the Topic to Vote On" id="form-control" class="spc-n" required>
            <input type="hidden" name="admin" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" required>
            <br></br>
            <textarea name="" id="" cols="30" rows="10" class="spc-n" placeholder="Write additional details about the topic (Optional)"></textarea>
            <br></br>
            <input class="btn btn-primary" type="submit">
        </div>
      </form>
    </section>

    <script src="../../../../scripts/jquery-min.js"></script>
    <script src="../../scripts/bootstrap.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="../../scripts/particles.js"></script>
    <script type="text/javascript" src="../../scripts/app.js"></script>
    <script src="../../scripts/main.js"></script>
</body>
</html>