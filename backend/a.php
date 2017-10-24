<?php
// $link = mysqli_connect("bsdb.ctbj58rdgaop.us-west-2.rds.amazonaws.com", "cs130", "ilovecs130", "db1");

// if (!$link) {
//     echo "Error: Unable to connect to MySQL." . PHP_EOL;
//     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }

// echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
// echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

// mysqli_close($link);

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// $host = "localhost";
// echo $host;
// // $conn = new mysqli($host, 'potplus_cs130', 'apassword', 'potplus_bruinswitchdb');

// $conn = new mysqli($host,"potplus_cs130","e^y+xJb7AL.V", "potplus_omelettedb", 3306);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// // Check connection
// if($conn === true){
//     echo "Connect Successfully. Host info: ".$conn->host_info;
// }
// else
// { 
//     die("ERROR: Could not connect. " . $conn->connect_error);
// }

// if ($conn->query("CREATE TABLE MyGuests (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     email VARCHAR(50),
//     reg_date TIMESTAMP
//     )") == true)
// {
//     echo "yeee";
// }
// else
// {
//     echo "error:" . $conn->error;
// }
echo shell_exec("python switchhub.py --user='potplus' --password='1234' --action='loginuser'");
?>
<!-- <html>
<head>
<meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
<title>The Bobby Omelette Tea Company</title>
<link rel='copyright' href='a.php'>
<link rev='made' href='mailto:potplus@live.com'>
</head>

<body>

<h1>The Bobby Omelette Tea Company</h1>

</body>
</html> -->