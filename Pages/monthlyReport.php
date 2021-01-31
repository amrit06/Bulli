<?php
session_start();
$success= "";
$result=array();
include_once '../config/Database.php';
include_once '../model/Table.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $conn = new Database();
    $db = $conn->connect('NewBulli.db');
    $table = new Table($db);
    echo "Income <br></br>";
    $monthly = $table->getMonthlyReport($_POST["month"], $_POST["year"]);
    print_r($monthly);
}

?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="yearlyMonthlyStyle.php">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css%22%3E">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js%22%3E"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<script type="text/javascript">
$("<select />").appendTo("nav");

// Create default option "Go to..."
$("<option />", {
   "selected": "selected",
   "value"   : "",
   "text"    : "Go to..."
}).appendTo("nav select");

// Populate dropdown with menu items
$("nav a").each(function() {
 var el = $(this);
 $("<option />", {
     "value"   : el.attr("href"),
     "text"    : el.text()
 }).appendTo("nav select");
});
</script>

<!-- Top navigation -->
<div class="topnav">
  <!-- Centered link -->
  <div class="topnav-centered">
	<h2>Monthly Report Generator</h2>

    <!--<a href="#home" class="active">Home</a>-->
  </div>

  <button onclick="window.location.href='HomePage.php'" class="homeButton"><i class="fa fa-home"></i></button>

  <!-- Left-aligned links (default) -->
  <a href="loginscreen.php" class="logoff">Log Off</a>


  <!-- centered links -->
  <div class="topnav-center">
    <nav>
      <ul class = "hide2">
		<a href="cashAccount/cashaccount.php">Cash</a>
		<a href="bendigoAccount/bendigoaccount.php">Bendigo</a>
		<a href="DGRAccount/DGRaccount.php">DGR</a>
		<a href="cardsAccount/cardsaccount.php">Cards</a>
		<a href="depositAccount/depositaccount.php">Deposit</a>
		<a href="socialAccount/socialaccount.php">Social</a>
      </ul>


	 <select class = "test3 box" onchange= "location = this.value;" >
      <option value="" selected="selected">Select</option>
      <option value="cashAccount/cashaccount.php" cash="cash">Cash</option>
      <option value="bendigoAccount/bendigoaccount.php" bendigo="bendigo">Bendigo</option>
      <option value="DGRAccount/DGRaccount.php" dgr="dgr">DGR</option>
      <option value="cardsAccount/cardsaccount.php" cards="cards">Cards</option>
      <option value="depositAccount/depositaccount.php" deposit="deposit">Deposit</option>
      <option value="socialAccount/socialaccount.php" social="social">Social</option>
     </select>


    </nav>

  </div>

  <div class="topnav-right test2">
  <nav>
	 <ul class = "hide">
   <?php
    if ($_SESSION['status'] === "admin") {
      echo '  <a href="yearlyReport.php">Extract Data for Yearly Report</a>';
      echo ' 	<a href="monthlyReport.php">Monthly Report Generator</a>';
      echo ' <a href="searchFilterPage.php" class="topnav-right2">Search/Filter</a>';
    }
    else {
      echo ' <a href="searchFilterPage.php" >Search/Filter</a> '; 
    }?>
    </ul>

    <select class = "test box" onchange= "location = this.value;" >
	  <option value="" selected="selected">Select</option>
    <?php
    if ($_SESSION['status'] === "admin") {
      echo '  	  <option value ="yearlyReport.php"> Extract Data for Yearly Report </option>';
      echo ' <option value="monthlyReport.php" >Monthly Report Generator</option>';
    
    }?>
	  <option value="searchFilterPage.php" >Search/Filter</option>
	 </select>
	</nav>

  </div>

</div>
<br><br><br>
            <div class="form">
            <div class="form">
              <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
              <section class="inputValues">
                    <label for="date"> Enter the month in the year you want to see:</label>
                    <br><br>
					<select name="month" id="month">
                <option value=""></option>
								<option value="1">Jan</option>
								<option value="2">Feb</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
					</select>		
          <select name="year" id="year">
                <option value=""></option>
								<option value="2012">2012</option>
								<option value="2013">2013</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
					</select>	  
                    <br><br>
                </section>
                <section class="completed">
                    <input type="submit" class="button3" value="Generate Report">
                </section>
              </form>
            </div>
        </body>


</html>
