<?php
    // making it connect to php pages
    header("Content-type: text/css; charset: UTF-8");
?>

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  margin-left: 150px;
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

* {
  box-sizing: border-box;
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

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}

#myTable2 {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
  margin-left: 450px;
}