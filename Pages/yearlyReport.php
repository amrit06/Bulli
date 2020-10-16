<?php
session_start();
$success= "";
$result=array();
include_once '../config/Database.php';
include_once '../model/Table.php';
date_default_timezone_set('UTC');

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new Database();
  $db = $conn->connect('NewBulli.db');
  $table = new Table($db);
  $result = $table->getYearlyClosingBalances($_POST["dateFrom"], $_POST["dateTo"]);
  print_r($result); // result is the data
  }*/
  
if(isset($_POST['generate']))
{
	$conn = new Database();
    $db = $conn->connect('NewBulli.db');
    $table = new Table($db);
	$data = $table->getYBalances($_POST["dateFrom"], $_POST["dateTo"]);
	
	//----------------------------------------------------------Anime Opening ----------------------------------------------------------------------//
	$opening = array();
	$opening = $table->getOpeningBalances($_POST["dateFrom"]);
	
	//--------------------------------------------------Get Data for Yearly Giraffe-----------------------------------------------------------------//
	
	$bendigoArray = array();
	$cardArray = array();
	$cashArray = array();
	$dgrArray = array();
	$depositArray = array();
	$socialArray= array();
	
	//arrayStoring(account number, the array of array, account array)
	for($i = 0; $i < 6; $i++)
	{
		switch($i)
		{
			case 0:
				$bendigoArray = arrayStoring($i, $data, $bendigoArray, $opening[$i]["balance"], $_POST["dateFrom"] );
				break;
			case 1:
				$cardArray = arrayStoring($i, $data, $cardArray, $opening[$i]["balance"], $_POST["dateFrom"]);
				break;
			case 2:
				$cashArray = arrayStoring($i, $data, $cashArray, $opening[$i]["balance"], $_POST["dateFrom"]);
				break;
			case 3:
				$dgrArray = arrayStoring($i, $data, $dgrArray, $opening[$i]["balance"], $_POST["dateFrom"]);
				break;
			case 4:
				$depositArray = arrayStoring($i, $data, $depositArray, $opening[$i]["balance"], $_POST["dateFrom"]);
				break;
			case 5:
				$socialArray = arrayStoring($i, $data, $socialArray, $opening[$i]["balance"], $_POST["dateFrom"]);
				break;
				
		}
	}
	
	$startDate = DateTime::createFromFormat("Y-m-d", $_POST["dateFrom"]);
	$getYear = $startDate->format("Y");
	//echo $getYear, "<br>";
	
	$year = $getYear;
	$days = 91;
	
	$days = sprintf("%03d", $days);
	
	//echo $days, "<br>"; 
	$myfile = fopen("Yearly.txt", "w+") or die("Unable to open file!");
	for($i = 0; $i <= 364; $i++)
	{
		if($days > 365)
		{
			$temp = 001;
			$days = sprintf("%03d", $temp);
			$year += 1;
		}
		$txt = $year.$days . "," . $bendigoArray[$i] . "," . $cardArray[$i] . "," . $cashArray[$i] . "," . $dgrArray[$i] . "," . $depositArray[$i] . "," . $socialArray[$i] . "\n";
		fwrite($myfile, $txt);
		$days++;
		$days = sprintf("%03d", $days);
		
	}
	fclose($myfile);
	//------------------------------------------------------End of Calculating/Writing Financial Year Stuff--------------------------------------------------------------//
	
	//---------------------------------------------------------Start of Incomes and Expenses Calculation-----------------------------------------------------------------//
	
	$category = array("equipment", "hardware", "internet", "welfare", "stationary", "cleaning", "fee", "other", "transfer", "fundrising", "donation", "refund", "interest", "investment");
	
	for($i = 0; $i < sizeof($category); $i++)
	{
		$getCat = $table->getCategoryIncoExpe($category[$i], $_POST["dateFrom"], $_POST["dateTo"]);
		$data2[] = $getCat;
	}

	//---------------------------------------------------------Incomes the BOOM-----------------------------------------------------------------//
	$myfile = fopen("Incomes.txt", "w+") or die("Unable to open file!");
	for($i = 0; $i < sizeof($category); $i++)
	{
		//$txt = $category[$i] . "," . $data2[$i]["Income"] . "\n";
		
		if( $i == (sizeof($category)-1))
		{
			$txt = $data2[$i]["Income"];
		}
		else
		{
			$txt = $data2[$i]["Income"] . ",";
		}
		fwrite($myfile, $txt);
	}
	fclose($myfile);
	
	//---------------------------------------------------------Ex(-Girlfriend)penses-----------------------------------------------------------------//
	$myfile = fopen("Expenses.txt", "w+") or die("Unable to open file!");
	for($i = 0; $i < sizeof($category); $i++)
	{
		//$txt = $category[$i] . "," . $data2[$i]["Expense"] . "\n";
		if( $i == (sizeof($category)-1))
		{
			$txt = $data2[$i]["Expense"];
		}
		else
		{
			$txt = $data2[$i]["Expense"] . ",";
		}
		fwrite($myfile, $txt);
	}
	fclose($myfile);
	
	//---------------------------------------------------------Anime Ending-----------------------------------------------------------------//
	$data3 = $table->getYearlyClosingBalances($_POST["dateTo"]);
	
	$myfile = fopen("Closing.txt", "w+") or die("Unable to open file!");
	for($i = 0; $i < sizeof($data3); $i++)
	{
		//echo $data3[$i]["balance"], "<br>";
		if( $i == (sizeof($data3)-1))
		{
			$txt = $data3[$i]["balance"];
		}
		else
		{
			$txt = $data3[$i]["balance"] . ",";
		}
		fwrite($myfile, $txt);
	}
	fclose($myfile);
	
	//---------------------------------------------------------Zip it up boi (STICKY FINGAAASS!)-----------------------------------------------------------------//
	$za = new ZipArchive();
	//$za->open('Files.zip');
	if ($za->open("Files.zip", ZipArchive::CREATE)!==TRUE)	 
	{
		exit("cannot open <$filename>\n");
	}	
	
	$za->addFile("Yearly.txt", "Yearly.txt");
	$za->addFile("Incomes.txt", "Incomes.txt");
	$za->addFile("Expenses.txt", "Expenses.txt");
	$za->addFile("Closing.txt", "Closing.txt");
	
	
}


function arrayStoring($accNum, $theData, $storeData, $openBal, $startDate)
{
	$bal = $openBal;
	//$start = "1/4/2018";
	//$iDate = convertDate($start);
	$iDate = $startDate;
	
	$count = 0;
	$getDate = $theData[$accNum][$count]["date"];
	$converted = convertDate($getDate);

	
	for($j = 0; $j <= 365; $j++)
	{
		//echo $converted, " <-Converted ";
		if($iDate == $converted)
		{
			//echo " Date Checked  ";
			//echo $converted, " <-Converted ";
		
			$bal = $theData[$accNum][$count]["balance"];	
			
			$flag = true;
			while($flag == true && ($count + 1) != sizeof($theData[$accNum])) //Handle duplicate entries on same day
			{
				if($theData[$accNum][$count]["date"] == $theData[$accNum][$count+1]["date"]) 
				{
					$bal = $theData[$accNum][$count+1]["balance"];
					
				}
				else
				{
					$flag = false;
				}
				
				$count++;				
			}
			
			$count--;
			//echo $bal, " <-Balance ";
			//echo "(count is: ", $count, ") ";	
			
			
			if($count <= sizeof($theData[$accNum]))
			{
				$getDate = $theData[$accNum][$count+1]["date"]; //Get next record before incrementing count for write format purposes
				$converted = convertDate($getDate);
				//echo "count exceeded <br>";	
			}
			$count++;								
		}
		
		$storeData[] = $bal;
		
		//echo $iDate, " <-iDate <br> ";
		$iDate = strtotime("+1 day", strtotime($iDate));
		$iDate = date("Y-m-d", $iDate);
		
	}
	
	return $storeData;
}


function convertDate($dateCon)
{
	$str = str_replace('/', '-', $dateCon);
	$convert = date('Y-m-d', strtotime($str));
	
	return $convert;
	
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
	<h2>Extract Data for Yearly Reports</h2>

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
    <a href="yearlyReport.php">Extract Data for Yearly Report</a>
 		<a href="monthlyReport.php">Monthly Report Generator</a>
 		<a href="searchFilterPage.php" class="topnav-right2">Search/Filter</a>
	 </ul>


	 <select class = "test box" onchange= "location = this.value;" >
	  <option value="" selected="selected">Select</option>
	  <option value ="yearlyReport.php"> Extract Data for Yearly Report </option>
	  <option value="monthlyReport.php" >Monthly Report Generator</option>
	  <option value="searchFilterPage.php" >Search/Filter</option>
	 </select>


	</nav>

  </div>

</div>
<br><br><br>
            <div class="form">
              <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                  <section class="inputValues">
                    <label for="date"> Enter the period for the current financial year</label>
                    <br><br>
                    <label for="date"></label>
                    <input type="date" id="dateFrom" name="dateFrom"br>
                    <label for="date">To:</label>
                    <input type="date" id="dateTo" name="dateTo"br>
                    <br><br>
                </section>
                <section class="completed">
                    <input type="submit" class="button3" name="generate" value="Generate Text Files" >
                </section>
              </form>
            </div>	
			
			<?php
			if(isset($_POST['generate']))
			{
				echo '<div class="positionLink"> <a href="Files.zip" download> Download Zip</a> </div>';
			}
			?>
		
		
       </body>


</html>
