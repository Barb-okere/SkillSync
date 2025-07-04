<?php
$server_name = "localhost";
$server_user = "root";
$server_password = "";

// establish connection to the server - mysqli_connect()
$connect = mysqli_connect($server_name, $server_user, $server_password);
// check if the connection has started 
if ($connect){
    echo "connection successful";
} else{
    // mysqli_connect_error() will return the error message if the connection fails
    //
    die(mysqli_connect_error($connect));
}
// Write a query to create a database
$query = "CREATE DATABASE IS1ProjectDbase";
// execute query - mysqli_query(connection, query)
$query_result = mysqli_query($connect, $query);
// check if query is successful
if ($query_result) {
    echo "<br> Database created successfully";
} else {
    // mysqli_error() will return the error message if the query fails
    echo "<br> Database not created successfully";
}
