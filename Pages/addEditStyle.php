<?php
    // making it connect to php pages
    header("Content-type: text/css; charset: UTF-8");
?>
.inputValues, .completed{
  text-align: center;
}

.button {
  background-color: rgb(32, 56, 100);
  border: none;
  color: white;
  padding: 12px 20px 12px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  margin-left: 150px;

}

.completed{
  margin-right: 138px;
}

.button2 {
  background-color: rgb(32, 56, 100);
  border: none;
  color: white;
  padding: 10px 16px 10px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;

}

.button3 {
  background-color: rgb(32, 56, 100);
  border: none;
  color: white;
  padding: 10px 8px 10px 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  cursor: pointer;
  margin-left: 138px;
  width: 7%;
  border-radius: 4px;
}

.reset {
  margin-right: 177px;
}


#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 20%;
  font-size: 16px;
  padding: 12px 20px 12px 10px;
  border: 1px solid #ddd;
  margin-left: 695px;
}


body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
body {
    height: 100%;
    /*background: linear-gradient(90deg, #FFC0CB 50%, #00FFFF 50%);*/
	background-color: rgb(203, 227, 255);
}

.h2Style {
  text-align: center;
}

/*----------------------------------input values----------------------------------*/


#date {
  width: 20%;
  height: 25px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}

#item {
  width: 20%;
  height: 25px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}

#income {
  width: 20%;
  height: 25px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}

#expense {
  width: 20%;
  height: 25px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}

#CategoryId {
  width: 20.5%;
  height: 35px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}

#myfile {
  width: 20%;
  height: 30px;
  padding: 6px 4px 6px 6px;
  font-size: 15px;
}


.logoff {
	position: absolute;
	top: 55%;
	margin-left: 50px;
	width: 80px;
    border: 1px solid rgb(205, 205, 205);
	margin-top: -1px;
}

.topnav {
  position: relative;
  overflow: hidden;
  background-color: rgb(34, 42, 53);
  height: 165px;
}

/*----------------------------------Home Button----------------------------------*/
.homeButton {
  background-color: rgb(241, 241, 241);
  border: 1px solid rgb(205, 205, 205);
  color: black;
  padding: 6.5px 14px;
  font-size: 20px;
  cursor: pointer;
  position: absolute;
  top: 55%;
  margin-top: -1px;
  margin-left: 200px;
}

.homeButton:hover {
  background-color: rgb(102, 102, 102);
}

/*----------------------------------topnav right----------------------------------*/
.topnav-right {
  float: right;
  position: absolute;
  top: 30%;
  right: 5%;
  margin-left: -242px;
  height: 120px;
}

.topnav-right a {
	border: 1px solid rgb(205, 205, 205);

}

.topnav-right2 {
  position: absolute;
  top: 50%;
  left: 204px;
}

/*----------------------------------topnav----------------------------------*/
.topnav a {
  float: left;
  color: black;
  text-align: center;
  padding: 10px 20px;
  text-decoration: none;
  font-size: 14px;
  background-color: rgb(241, 241, 241);
}


.topnav a:hover {
  background-color: rgb(102, 102, 102);
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.topnav h2 {
  color: white;
}

/*----------------------------------topnav centered----------------------------------*/
.topnav-centered h2 {
  float: none;
  position: absolute;
  top: 15%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
}

/*----------------------------------topnav center----------------------------------*/
.topnav-center {
  /*float: none;
  width: 50%;
  top: 50%;
  left: 31.6%;*/

  position: absolute;
  margin-left: -330px;
  top: 45%;
  left: 50%;
  width: 700px;
}

.topnav-center nav ul a{
    width: 10%;
    border: 1px solid rgb(205, 205, 205);
}

.topnav-center nav ul {
   position: absolute;
   left: -46px;
   width: 100%;
}

/*----------------------------------Other Stuff----------------------------------*/
.box{
	/*width: 210px;*/
    height: 30px;
    border: 1px solid #999;
    font-size: 14px;
    color: black;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #eee;
}


nav select {
  display: none;
}

/*----------------------------------Screen Reso Stuff----------------------------------*/
@media (max-width: 1730px) {
  /*nav ul{
  display: none;
  }

  /*nav select {
  display: block;
  position: absolute;
  top: 20%;
  margin-left: -245px;
  }*/

  .hide{
	  display: none;
  }


  .test {
	display: block;
	position: absolute;
	top: 13%;
	margin-left: -170px;
  }



}


@media (max-width: 1180px){

	.test2 {
	  float: none;
	  position: absolute;
	  margin-left: 62px;
      top: 70%;
      left: 50%;
	}

	.homeButton {
		margin-left: 58px;
		top: 38%;
	}

	.logoff {
		margin-left: 20px;
		top:65%;
	}



}

@media (max-width: 955px){


	.test3 {
	  display:block;
	  float: none;
	  position: absolute;
	  margin-left: -58px;
      top: 50%;
      left: 50%;
	  /* width: 150px;*/
	}

	.hide2 {
		display: none;
	}




}

/* Responsive navigation menu (for mobile devices) */
@media screen and (max-width: 600px) {
  .topnav a, .topnav-center {
    float: none;
    display: block;
  }

  .topnav-centered a {
    position: relative;
    top: 0;
    left: 0;
    transform: none;
  }
}
