<?php

start();

function start(){
  echo "Please choose action: get all clients(get), add a client(add), update client's info (update), remove a client (delete), load client data (load) or exit the program (exit)";
  echo "\n";
  $input = fopen ("php://stdin","r");
  $action = trim(fgets($input));
  if($action == 'add'){
      addClient();
  }
  elseif($action == 'get'){
      getClients();
  }
  elseif($action == 'update'){
      updateClient();
  }
  elseif($action == 'delete'){
      deleteClient();
  }
  elseif($action == 'exit'){
      echo "Program stopped.";
      echo "\n";
      exit();
  }
  elseif($action == 'load'){
      loadData();
  }
  else {
    echo "Incorrect input.";
    echo "\n";
    repeat();
  }
}

function repeat(){
  echo "Please choose again one of the following actions to continue: get, add, update, delete, load, exit";
  echo "\n";
  $input = fopen ("php://stdin","r");
  $action = trim(fgets($input));
  if($action == 'add'){
      addClient();
  }
  elseif($action == 'get'){
      getClients();
  }
  elseif($action == 'update'){
      updateClient();
  }
  elseif($action == 'delete'){
      deleteClient();
  }
  elseif($action == 'load'){
      loadData();
  }
  elseif($action == 'exit'){
      echo "Program stopped.";
      echo "\n";
      exit();
  }
  else {
    echo "Incorrect input. ";
    echo "\n";
    start();
  }
}

function getClients(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "client";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT ID, firstName, lastName, email, phoneNumber1, phoneNumber2, comment FROM databaseclient";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $str= "Client ID: ".$row["ID"]." First name: ".$row["firstName"]." Last name: ".$row["lastName"]." Email: ".$row["email"]. " Phone number 1: ".$row["phoneNumber1"]  . " Phone number 2: " . $row["phoneNumber2"] . " Comment " . $row["comment"] ;
            $str = str_replace(array("\r\n", "\n", "\r"), ' ', $str);
            echo $str;
            echo "\n";
        }
        repeat();
    } else {
        echo "0 results";
        echo "\n";
        repeat();
    }
    $conn->close();
}

function addClient(){
  echo "Please enter client information below.";
  echo "\n";
  //asking for inputs (email, phone 1 and phone 2 are validated) and saving them
  echo "Client first name: ";
  $input1 = fopen ("php://stdin","r");
  $firstName = trim(fgets($input1));
  echo "Client second name: ";
  $input2 = fopen ("php://stdin","r");
  $lastName = trim(fgets($input2));
  echo "Client email name: ";
  $input3 = fopen ("php://stdin","r");
  $email = trim(fgets($input3));
  while (!(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email))){
    echo "Invalid email. Enter email that would consist of something before '@' sign, '@' itself, then some content before '.' sign and after it. For example, 'something@gmail.com'.";
    echo "\n";
    echo "Client email name: ";
    $input3 = fopen ("php://stdin","r");
    $email = trim(fgets($input3));
  }
  echo "Client phone number 1: ";
  $input4 = fopen ("php://stdin","r");
  $phoneNumber1 = trim(fgets($input4));
  while (preg_match("/^[+]{1}[0-9]{11}$/", $phoneNumber1) == 0 & preg_match("/^[0-9]{9}$/", $phoneNumber1) == 0 ) {
    echo "Invalid telephone number format. Please enter 9-digit (excluding + sign) or 11-digit (including first '+' sign) telephone number:";
    echo "\n";
    echo "Client phone number 1: ";
    $input4 = fopen ("php://stdin","r");
    $phoneNumber1 = fgets($input4);
  };
  echo "Client phone number 2: ";
  $input5 = fopen ("php://stdin","r");
  $phoneNumber2 = trim(fgets($input5));
  while (preg_match("/^[+]{1}[0-9]{11}$/", $phoneNumber2) == 0 & preg_match("/^[0-9]{9}$/", $phoneNumber2) == 0 ) {
    echo "Invalid telephone number format. Please enter 9-digit (excluding '+' sign) or 11-digit (including first '+' sign) telephone number:";
    echo "\n";
    echo "Client phone number 1: ";
    $input5 = fopen ("php://stdin","r");
    $phoneNumber2 = fgets($input5);
  };
  echo "Enter client's comment: ";
  $input6 = fopen ("php://stdin","r");
  $comment = trim(fgets($input6));
  //db credentials
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "client";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "INSERT INTO databaseclient (firstName, lastName, email, phoneNumber1, phoneNumber2, comment)
  VALUES ('$firstName', '$lastName', '$email', '$phoneNumber1', '$phoneNumber2','$comment' )";

  if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
      echo "\n";
      repeat();
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      echo "\n";
      repeat();
  }
  $conn->close();
}

function deleteClient(){
  echo "Please enter client's ID which you would like to delete. You can view client's ID by writing 'get' into console.";
  echo "\n";
  //asking for inputs and saving them
  $input = fopen ("php://stdin","r");
  $clientDeleteID = trim(fgets($input));
  if ($clientDeleteID == 'get'){
    getClients();
  }
  //db credentials
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "client";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  //sql to delete a record
  $sql = "DELETE FROM databaseclient WHERE ID='$clientDeleteID'";
  $conn->query($sql);
  printf("Affected rows (DELETE): %d\n", $conn->affected_rows);
  if ( $conn->affected_rows>0) {
      echo "Record deleted successfully";
      echo "\n";
      repeat();
  } else {
      echo "Please check if client ID that you have entered exists. Error deleting record. ";
      echo "\n";
      repeat();
  }
  $conn->close();
}

function updateClient(){
  echo "Please enter client's ID which information you would like to change. You can view client's ID by writing 'get' into console.";
  echo "\n";
  //asking for inputs and saving them
  $input = fopen ("php://stdin","r");
  $clientUpdateID = trim(fgets($input));
  if ($clientUpdateID == 'get'){
    getClients();
  }
  echo "Please enter new client information below.";
  echo "\n";
  //asking for inputs and saving them
  echo "Client first name: ";
  $input1 = fopen ("php://stdin","r");
  $firstName = trim(fgets($input1));
  echo "Client second name: ";
  $input2 = fopen ("php://stdin","r");
  $lastName = trim(fgets($input2));
  echo "Client email name: ";
  $input3 = fopen ("php://stdin","r");
  $email = trim(fgets($input3));
  while (!(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email))){
    echo "Invalid email. Enter email that would consist of something before '@' sign, '@' itself, then some content before '.' sign and after it. For example, 'something@gmail.com'.";
    echo "\n";
    echo "Client email name: ";
    $input3 = fopen ("php://stdin","r");
    $email = trim(fgets($input3));
  }
  echo "Client phone number 1: ";
  $input4 = fopen ("php://stdin","r");
  $phoneNumber1 = trim(fgets($input4));
  while (preg_match("/^[+]{1}[0-9]{11}$/", $phoneNumber1) == 0 & preg_match("/^[0-9]{9}$/", $phoneNumber1) == 0 ) {
    echo "Invalid telephone number format. Please enter 9-digit (excluding + sign) or 11-digit (including first '+' sign) telephone number:";
    echo "\n";
    echo "Client phone number 1: ";
    $input4 = fopen ("php://stdin","r");
    $phoneNumber1 = trim(fgets($input4));
  };
  echo "Client phone number 2: ";
  $input5 = fopen ("php://stdin","r");
  $phoneNumber2 = trim(fgets($input5));
  while (preg_match("/^[+]{1}[0-9]{11}$/", $phoneNumber2) == 0 & preg_match("/^[0-9]{9}$/", $phoneNumber2) == 0 ) {
    echo "Invalid telephone number format. Please enter 9-digit (excluding '+' sign) or 11-digit (including first '+' sign) telephone number:";
    echo "\n";
    echo "Client phone number 1: ";
    $input5 = fopen ("php://stdin","r");
    $phoneNumber2 = trim(fgets($input5));
  };
  echo "Enter client's comment: ";
  $input6 = fopen ("php://stdin","r");
  $comment = trim(fgets($input6));
  //db credentials
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "client";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  // sql to update a record
  $sql = "UPDATE databaseclient SET firstName='$firstName',lastName='$lastName',email='$email',phoneNumber1='$phoneNumber1',phoneNumber2='$phoneNumber2',comment='$comment' WHERE ID = '$clientUpdateID'";
  $conn->query($sql);
  printf("Affected rows (UPDATE): %d\n", $conn->affected_rows);
  if ($conn->affected_rows>0) {
      echo "Record updated successfully";
      echo "\n";
      repeat();
  } else {
      echo "Error updating record. Please check if your entered client ID was valid.";
      echo "\n";
      repeat();
  }
  $conn->close();
}

function loadData(){
  //db credentials
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "client";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "LOAD DATA LOCAL INFILE 'import-folder/example-feed.csv' INTO TABLE databaseclient FIELDS TERMINATED BY ',' IGNORE 1 LINES";
  if ($conn->query($sql) === TRUE) {
      echo "File uploaded succesfully.";
      echo "\n";
      repeat();
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      echo "\n";
      repeat();
  }
}

?>
