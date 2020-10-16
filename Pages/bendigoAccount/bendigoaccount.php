<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../../config/Database.php';
include_once '../../model/Table.php';
?>

<!DOCTYPE html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../accountStyle.php">
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
	<h2>Bendigo Account</h2>

    <!--<a href="#home" class="active">Home</a>-->
  </div>

  <button onclick="window.location.href='../HomePage.php'" class="homeButton"><i class="fa fa-home"></i></button>

  <!-- Left-aligned links (default) -->
  <a href="../loginscreen.php" class="logoff">Log Off</a>


  <!-- centered links -->
  <div class="topnav-center">
    <nav>
      <ul class = "hide2">
		<a href="../cashAccount/cashaccount.php">Cash</a>
		<a href="../bendigoAccount/bendigoaccount.php">Bendigo</a>
		<a href="../DGRAccount/DGRaccount.php">DGR</a>
		<a href="../cardsAccount/cardsaccount.php">Cards</a>
		<a href="../depositAccount/depositaccount.php">Deposit</a>
		<a href="../socialAccount/socialaccount.php">Social</a>
      </ul>


	 <select class = "test3 box" onchange= "location = this.value;" >
      <option value="" selected="selected">Select</option>
      <option value="../cashAccount/cashaccount.php" cash="cash">Cash</option>
      <option value="../bendigoAccount/bendigoaccount.php" bendigo="bendigo">Bendigo</option>
      <option value="../DGRAccount/DGRaccount.php" dgr="dgr">DGR</option>
      <option value="../cardsAccount/cardsaccount.php" cards="cards">Cards</option>
      <option value="../depositAccount/depositaccount.php" deposit="deposit">Deposit</option>
      <option value="../socialAccount/socialaccount.php" social="social">Social</option>
     </select>


    </nav>

  </div>

  <div class="topnav-right test2">
	<nav>
	 <ul class = "hide">
   <?php
    if ($_SESSION['status'] === "admin") {
      echo '  <a href="../yearlyReport.php">Extract Data for Yearly Report</a>';
      echo ' 	<a href="../monthlyReport.php">Monthly Report Generator</a>';
      echo ' <a href="../searchFilterPage.php" class="topnav-right2">Search/Filter</a>';
    }
    else {
      echo ' <a href="../searchFilterPage.php" >Search/Filter</a> '; 
    }?>
    </ul>

    <select class = "test box" onchange= "location = this.value;" >
	  <option value="" selected="selected">Select</option>
    <?php
    if ($_SESSION['status'] === "admin") {
      echo '  	  <option value ="../yearlyReport.php"> Extract Data for Yearly Report </option>';
      echo ' <option value="../monthlyReport.php" >Monthly Report Generator</option>';
    
    }?>
	  <option value="../searchFilterPage.php" >Search/Filter</option>
	 </select>
	</nav>

  </div>

</div>

<body>

<?php
if ($_SESSION['status'] === "admin") {
echo '  <a href="bendigoadd.php" class="button">Create New Entry</a>';
}
?>
  <input type="text" id="myInput" onkeyup="searchAll()" placeholder="Search for Entry" title="Type in a name">
  <table class="center" style="width:80%" id="myTable">

    <col width="30">
    <col width="120">
    <col width="360">
    <col width="105">
    <col width="90">
    <col width="90">
    <col width="60">
    <col width="120">
    <col width="60">
    <col width="110">

    <tr class="header">
      <th>ID</th>
      <th>Date</th>
      <th>Item Description</th>
      <th>Income</th>
      <th>Expense</th>
      <th>Balance</th>
      <th>GST</th>
      <th>Category <button onclick="on()"> <b>?</b></button></th>
      <th>Invoice</th>
      <?php 
      if ($_SESSION['status'] === "admin") {
        echo '
      <th> </th> ';}
      ?>
    </tr>
    <?php

    $conn = new Database();
    $db = $conn->connect('NewBulli.db');
    $table = new Table($db);
    $result = $table->retrieveall('Bendigo');
    $size = sizeof($result);
    //print_r($result);
    for ($i = 0; $i < sizeof($result); $i++) {

      echo
        '
              <tr>
              <td>' . $result[$i]['Id'] . '</td>
              <td>' . $result[$i]['date'] . '</td>
              <td>' . $result[$i]['description'] . '</td>
              <td>' . $result[$i]['income'] . '</td>
              <td>' . $result[$i]['expense'] . '</td>
              <td>' . $result[$i]['balance'] . '</td>
              <td>' . (($result[$i]['gst'] == 1) ? "YES" : "NO") . '</td>
              <td>' . $result[$i]['Category'] . '</td>
              <td>
              '. (empty($result[$i]['invoice']) ? '' : '<a href="../invoice.php?invoice='.$result[$i]['Id'].'&& table=Bendigo ">PDF</a>' ).'
              </td>';
              if ($_SESSION['status'] === "admin") {
                echo '
              <td><a href="bendigomodify.php?id='.$result[$i]['Id'].'" class="button2">Edit Entry</a></td>
              </tr>
              ';}
    }

    $db->close();
    ?>
  </table>

  <div id="overlay" onclick="off()">
    <div id="oText">
      <h4>Category Descriptions</h4>
      Equipment: Brigade purchased equipment <br><br>
      Hardware: Small hardware items <br><br>
      Internet: Internet charges <br><br>
      Welfare: Welfare for crews <br><br>
      Stationary: Stationary and office supplies <br><br>
      Cleaning: Cleaning and hygiene products <br><br>
      Fee: Fees(subscriptions, etc.) <br><br>
      Other: Miscellaneous <br><br>
      Transfer: Transfer between accounts <br><br>
      Fundrising: Fundrising activites <br><br>
      Donation: Public donations <br><br>
      Refund: ATO refunds <br><br>
      Interest: Bank interests <br><br>
      Investment: Cash investment <br><br>
      </div> 
  </div>


  <script>
  function on() {
    document.getElementById("overlay").style.display = "block";
  }

  function off() {
    document.getElementById("overlay").style.display = "none";
  }
  </script>
  
  <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }

    function searchAll() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (var i = 1; i < tr.length; i++) {
        var tds = tr[i].getElementsByTagName("td");
        var flag = false;
        for(var j = 0; j < tds.length; j++){
          var td = tds[j];
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            flag = true;
          }
        }
        if(flag){
            tr[i].style.display = "";
        }
        else {
            tr[i].style.display = "none";

        }
      }
    }
  </script>
</body>

</html>
