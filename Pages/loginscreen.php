<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

const admin = 'admin'; // tad username login
const password = 'password'; // tad password login
const user = 'user'; // member username login
const userPassword = 'bullipass'; // member password login

session_start();
//for tad
if (isset($_POST['status']) && isset($_POST['password'])) //when form submitted
{


  if ($_POST['status'] === admin && $_POST['password'] === password)
  {
    $_SESSION['status'] = $_POST['status']; //write login to server storage
    header('Location:HomePage.php'); //redirect to main
  }
  else
  {
  }
}

// for member
if (isset($_POST['status']) && isset($_POST['password'])) //when form submitted
{
  if ($_POST['status'] === user && $_POST['password'] === userPassword)
  {
    $_SESSION['status'] = $_POST['status']; //write login to server storage
    header('Location:HomePage.php'); //redirect to main
  }
  else
  {
	echo "<script>alert('username for member is: user' + '\\n' + 'password for member is: bullipass');</script>";
	
  }
}

?>



<!DOCTYPE HTML>

	<head>
		<style>
		.center {
		  margin: 0;
		  position: absolute;
		  top: 30%;
		  left: 50%;
		  transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  text-align:center;
		  font-family: Arial, Helvetica, sans-serif;
		  color:white;
		  background-color: rgb(34, 42, 53);
		}
		.error {
		  color: rgb(255, 0, 0);
		}
		h1 {
		  font-size:50px;
		}
		body{
			font-size: 20px;
		}

		.button{
			background-color: rgb(32, 56, 100);
			border: none;
			color: white;
			padding: 8px 15px 8px 15px;
			text-align: center;
			width: 15%;
			font-size: 16px;
			border-radius: 4px;
		}
		.inputClass{
			width: 46%;
			height: 35px;
			padding: 6px 4px 6px 6px;
		}

		input {
		  text-align: left;
    }
		</style>
		<h1>Welcome to the Bulli RFS Brigade <br> Financial Records</h1>
	</head>
	<body class = "center">
		<p>Please log in with the relevant credentials<p>
		<form method="post" name="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		  <input class = "inputClass" type="text" id="status" placeholder="Username" name="status">
		  <br><br>
		  <input class = "inputClass" type="password" id="password" placeholder="Password" name="password">
		  <br><br>
		  <input type="checkbox" onclick="myFunction()"> <span style="font-size:15px;"> Show Password </span>
		  <br><br>
		  <input class= "button" type="submit" value="Login">
		</form>

		<script>
		function myFunction() {
		  var x = document.getElementById("password");
		  if (x.type === "password") {
		    x.type = "text";
		  } else {
		    x.type = "password";
		  }
		}

		</script>
	</body>
</html>
