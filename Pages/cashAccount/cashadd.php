<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../../config/Database.php';
include_once '../../model/Table.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dst=null;
  if(!empty($_FILES['invoice']['name'])) {
    $fnm=$_FILES['invoice']['name'];
    $dst="../../resources/migrationdata/allinvoices/".$fnm;
    $pdfDir = "../../resources/migrationdata/allinvoices/";
    $pdffile = $pdfDir . basename($_FILES['invoice']['name']);
    move_uploaded_file($_FILES['invoice']['tmp_name'], $pdffile);
  }

  $args = [];
  foreach($_POST as $k=>$v){
      if(!empty($v)){
          $args[$k] = $v;
      }
  }
  unset($args['table2']);
  $args['invoice']=$dst;
  print_r($args);
  $conn = new Database();
  $db = $conn->connect("NewBulli.db");
  $table = new Table($db);
  $table_name = $args['table'];
  $args['balance'] = $table->getLastBalance($table_name);
  if( !empty($_POST['income']) && !empty($_POST['expense'])  ){
      $args['balance'] = ($args['balance'] + $_POST['income']) - $_POST['expense'];
  }else if( !empty($_POST['income']) && empty($_POST['expense']) ){
      $args['balance'] = $args['balance'] + $_POST['income'];
  }else if( !empty($_POST['expense']) && empty($_POST['income']) ){
      $args['balance'] = $args['balance'] - $_POST['expense'];   
  }


  $result = $table->insertIntoTable($table_name,$args);

  if($result == true){
    if( !empty($_POST['table2']) && !empty($args['expense']) ){
      $args2 = array();
      $args2 = $args;
      $args2['balance'] = ($table->getLastBalance($_POST['table2'])) + $args['expense'];
      $args2['income'] = $args['expense'];
      $args2['expense'] = 0; 
      $args2['description'] = "Transfer From " . $table_name;
      $result2 = $table->insertIntoTable($_POST['table2'],$args2);

      if($result2 == true){
          echo "Success";
      }else{
          echo "Unsuccess";
      }
    }else{
      echo "Success";
  }
      header('Location:cashaccount.php');
  }else{
      echo "Unsuccess";
  }
  }
?>

<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
    #showMe{
    display:none;
    }
</style>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../addEditStyle.php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css%22%3E">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
  <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
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

$(":file").filestyle();


</script>

<!-- Top navigation -->
<div class="topnav">
  <!-- Centered link -->
  <div class="topnav-centered">

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
    <a href="../yearlyReport.php">Extract Data for Yearly Report</a>
 		<a href="../monthlyReport.php">Monthly Report Generator</a>
 		<a href="../searchFilterPage.php" class="topnav-right2">Search/Filter</a>
	 </ul>


	 <select class = "test box" onchange= "location = this.value;" >
	  <option value="" selected="selected">Select</option>
	  <option value ="../yearlyReport.php"> Extract Data for Yearly Report </option>
	  <option value="../monthlyReport.php" >Monthly Report Generator</option>
	  <option value="../searchFilterPage.php" >Search/Filter</option>
	 </select>


	</nav>

  </div>

</div>
    <body class="center">
    <h2 class="h2Style">Create New Entry for Cash Account</h2>
    <div class="form">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		  	<section class="inputValues">
			  	<input type="hidden" value="Cash" name="table"br>
			    <label for="date">Date:</label><br>
			    <input type="date" id="date" name="date"br>
			    <br><br>
			    <label for="item">Item Description:</label><br>
			    <input type="text" id="item" placeholder="A book of stamps" name="description"br>
			    <br><br>
			    <label for="income">Income:</label><br>
			    <input type="number" id="income" placeholder="2.25" name="income" min="0" step="0.01"br>
			    <br><br>
			    <label for="expense">Expense:</label><br>
			    <input type="number" id="expense" placeholder="2.25" name="expense" min="0" step="0.01"br>
			    <br><br>
			    <label for="gst"> GST:</label>
			    <input type="checkbox" id="gst" name="gst" value="gst">
			    <br><br>
			    <label for="category"> Category:</label><br>
					<select name="categoryId" id="CategoryId">
            <option value=""></option>
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
          <div id="showMe">
            <select class="default" id="transfer" name="table2">
              <option value="" selected>Select account...</option>
              <option value="Cash">Cash</option>
              <option value="Bendigo">Bendigo</option>
              <option value="DGR">DGR</option>
              <option value="Card">Cards</option>
              <option value="Deposit">Deposit</option>
            </select>
            <br><br>
          </div>
          <script type="text/javascript">
            var elem = document.getElementById("CategoryId");
            elem.onchange = function(){
                var hiddenDiv = document.getElementById("showMe");
                hiddenDiv.style.display = (this.value == "9") ? "block":"none";
            };
          </script>

			    <label for="myfile">Choose Invoice:</label><br>
          <input type="file" id="myfile" name="invoice">
			    <br><br>
				</section>
        <section class="completed">
          <input type="submit" class="button3" value="Submit">
          <input type="reset" class="button3" value="Clear Fields">
          <br>
          <a href="cashaccount.php">Back to list</a>
        </section>
      </form>
    </div>
  </body>
</html>
