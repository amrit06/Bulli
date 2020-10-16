<?php
session_start();
include_once '../config/Database.php';
include_once '../model/Table.php';

?>

<!DOCTYPE html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="searchFilterStyle.php">
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
	<h2>Search/Filter Page</h2>

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

<div class="form">
              <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                  <section class="inputValues">
                    <label for="date"> Enter the period</label>
                    <br><br>
                    <label for="date"></label>
                    <input type="date" id="dateFrom" name="startdate"br>
                    <label for="date">To:</label>
                    <input type="date" id="dateTo" name="enddate"br>
                    <br><br>
                    <label for="gst"> GST:</label>
                    <input type="checkbox" id="gst" name="gst" value="1">
                    <br><br>
                    <label for="category"> Category:</label><br>
					          <select name="category" id="CategoryId">
                      <option value="All">All Categories</option>
								      <option value="1">equipment</option>
								      <option value="2">hardware</option>
								      <option value="3">internet</option>
								      <option value="4">welfare</option>
								      <option value="5">stationary</option>
								      <option value="6">cleaning</option>
								      <option value="7">fee</option>
								      <option value="8">other</option>
								      <option value="9">transfer</option>
								      <option value="10">fundrising</option>
                      <option value="11">donation</option>
								      <option value="12">refund</option>
								      <option value="13">interest</option>
								      <option value="14">investment</option>
					          </select>
                    <br><br>
                    <label for="account"> Account:</label><br>
                    <select name="table" id="Account">
                      <option value="All">All Accounts</option>
								      <option value="Cash">Cash</option>
								      <option value="Bendigo">Bendigo</option>
								      <option value="DGR">DGR</option>
								      <option value="Cards">Cards</option>
								      <option value="Deposit">Deposit</option>
								      <option value="Social">Social</option>
					          </select>
					<br><br>
                </section>
                <section class="completed">
                    <input type="submit" class="button3" value="Generate data">
                </section>
              </form>
            </div>

  <table style="width:80%" id="myTable">
    <tr class="header">
      <th>Account</th>
      <th>Date</th>
      <th>Description</th>
      <th>Income</th>
      <th>Expense</th>
      <th>Balance</th>
      <th>GST</th>
      <th>Category</th>
    </tr>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    $table = new Table($db);
    $result = $table->SearchFilter($_POST['table'], $_POST['category'], $_POST['startdate'], $_POST['enddate'], $_POST['gst']);

    $tables = array("Bendigo", "Card", "Cash", "DGR", "Deposit", "Social");
    if ($_POST['table'] == "All") {
        for ($i = 0; $i < sizeof($result)-2; $i++) {

            if(!empty($result[$tables[$i]])) {
            for ($j = 0; $j < sizeof($result[$tables[$i]]); $j++) {
              echo 
              '
              <tr> ';
                echo'<td>' . $tables[$i] . '</td>';
                echo' <td>' . $result[$tables[$i]][$j]['date'] . ' </td> ';
                echo' <td>' . $result[$tables[$i]][$j]['description'] . ' </td> ';
                echo' <td>' . $result[$tables[$i]][$j]['income'] . ' </td> ';
                echo' <td>' . $result[$tables[$i]][$j]['expense'] . ' </td> ';
                echo' <td>' . $result[$tables[$i]][$j]['balance'] . ' </td> ';
                echo' <td>' . (($result[$tables[$i]][$j]['gst'] == 1) ? "YES" : "NO"). ' </td> ';
                if(!empty($result[$tables[$i]][$j]['category'])) {
                echo' <td>' . $result[$tables[$i]][$j]['category'] . ' </td> ';} else {
                  echo' <td/>';
                }
                echo 
            '
            </tr> ';
            }
          }
            
        }
    } else {
      if(!empty($result[$_POST['table']])) {
        for ($i = 0; $i < sizeof($result[$_POST['table']]); $i++) {
          echo 
        '
        <tr> ';
          echo'<td>' . $_POST['table'] . '</td>';
          echo' <td>' . $result[$_POST['table']][$i]['date'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['description'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['income'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['expense'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['balance'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['gst'] . ' </td> ';
          echo' <td>' .  $result[$_POST['table']][$i]['category'] . ' </td> ';
          echo 
          '
          </tr> ';}
        }
    }

}
    ?>

  </table>

<br><br><br><br>
      <?php
      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (!empty($_POST["gst"])) {
        echo '
        <table style="width:80%" id="myTable">
        <tr class="header">
          <th>TAXABLE ITEMS SERVICES TOTAL:</th>
          <th>GST PAID:</th>
        </tr> ';
      echo 
      '
      <tr> ';
          
          echo' <td>' . $result[0]['totalexpense'] . ' </td> ';
          echo' <td>' . $result[1]['gst'] . ' </td> ';
          
          echo 
          '
          </tr> </table>';
          
        }
      }
    ?>

</body>

</html>
