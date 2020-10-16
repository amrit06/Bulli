<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="homeStyle.php">
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
<?php
if ($_SESSION['status'] === "admin") {
echo '<h2>Welcome Tad!</h2> ';
}
else {
  echo '<h2>Welcome Member</h2> ';
}
?>
  <!-- Centered link -->
  <div class="topnav-centered">
	<h2>Home Page</h2>

    <!--<a href="#home" class="active">Home</a>-->
  </div>

  <button class="homeButton"><i class="fa fa-home"></i></button>

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

<div style="padding-left:16px">
  <!--<h2>It's ya boiz</h2>
  <p> Group PS2015</p>-->
</div>

<table class= "center" style="width:80%" id="style1">
        <tr class="header">
            <th>Account</th>
            <th>Current balance</th>
        </tr>
        <?php
        $conn = new Database();
        $db = $conn->connect('NewBulli.db');
        $table = new Table($db);
        $result = $table->getCurrentBalance();
        $size = sizeof($result);
        //echo $size;
        //print_r($result);
        echo
          '
        <tr>
            <td>Cash</td>
            <td>' . $result['Cash'] . '</td>
        </tr>
        <tr>
            <td>Bendigo</td>
            <td>' . $result['Bendigo'] . '</td>
        </tr>
        <tr>
            <td>DGR</td>
            <td>' . $result['DGR'] . '</td>
        </tr>
        <tr>
            <td>Cards</td>
            <td>' . $result['Card'] . '</td>
        </tr>
        <tr>
            <td>Deposit</td>
            <td>' . $result['Deposit'] . '</td>
        </tr>
        <tr>
            <td>Social</td>
            <td>' . $result['Social'] . '</td>
        </tr>
        ';
    $db->close();
  ?>
    </table>

</body>
</html>
