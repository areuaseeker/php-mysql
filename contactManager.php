<?php
// define variables and set to empty values
$firstNameErr= $lastNameErr = $emailErr = $cellErr = $homepageErr = $birthdateErr = "";
$firstName = $lastName = $email = $cell = $homepage = $birthdate = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstName"])) {
    $firstNameErr = "First Name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
      $firstNameErr = "Only letters and white space allowed";
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["lastName"])) {
      $nameErr = "Last name is required";
    } else {
      $lastName = test_input($_POST["lastName"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
        $lastNameErr = "Only letters and white space allowed";
      }
    }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["homepage"])) {
    $homepage = "";
  } else {
    $homepage = test_input($_POST["homepage"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$homepage)) {
      $homepageErr = "Invalid URL";
    }
  }

  if (empty($_POST["cell"])) {
    $cell = "";
  } else {
    $cell = test_input($_POST["cell"]);
    // check if cell phone syntax is valid (this regular expr)
    if (!preg_match("^[0-9]{3}-[0-9]{3}-[0-9]{4}$",$cell)) {
      $cellErr = "Invalid cell number";
    }
  }
  if (empty($_POST["birthdate"])) {
    $birthdate = "";
  } else {
    $birthdate = test_input($_POST["birthdate"]);
    // check if birthdate is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("^\d{4}-\d{2}-\d{2}$",$birthdate)) {
      $birthdateErr = "Invalid birthdate";
    }
  }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
/*
*************
comment out all the mysqli code for now leaving the pdo code
************
//mysqli object
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
// sql to create table
$sql = "CREATE TABLE Contacts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
fullname VARCHAR(30) NOT NULL,
email VARCHAR(50),
cell_no VARCHAR(30) NOT NULL,
birthdate DATE,
homepage VARCHAR(50),
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Contacts created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

//change this to use prepared statements
$sql = "INSERT INTO Contacts (firstname, lastname, email)
VALUES ('".$lastName.",".$firstName."," 'Doe', 'john@example.com')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//webpage table with data

$sql = "SELECT id, firstname, lastname FROM Contacts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["firstname"]." ".$row["lastname"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();

*/

//pdo
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "Contacts";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE Contacts";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
 // sql to create table
 try {
 $sql = "CREATE TABLE Contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    cell_no VARCHAR(30) NOT NULL,
    birthdate DATE,
    homepage VARCHAR(50),
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table Contacts created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

//prepared statement PDO example
$stmt = $conn->prepare("INSERT INTO Contacts (fullname, email, cell_no, birthdate, homepage)
VALUES (:fullname, :email, :cell_no, :birthdate, :homepage)");
$stmt->bindParam(':fullname', $lastName.", ".$firstName);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':cell_no', $cell);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':homepage', $homepage);
$stmt->execute();

if ($conn->query($stmt) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt . "<br>" . $conn->error;
}

echo "<h1>Contacts</h1>";
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Name</th><th>Email</th><th>Cell No.</th><th>Birthdate</th><th>Homepage</th><th>Delete</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }
//add delete button before </tr> based on record ID? except record ID should be last column passed to PHP delete need onclick html
    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "Contacts";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, firstname, lastname FROM Contacts");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";


$conn = null;

?>
