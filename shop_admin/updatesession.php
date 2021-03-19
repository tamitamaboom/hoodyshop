<?php
    session_start();
    include("connection.php");
    //echo "helloform update";
    $id = $_SESSION["UserID"];
    $callbyid = "SELECT * FROM Customer WHERE CustomerID=$id";
    $gotid = mysqli_query($conn,$callbyid);
    //echo mysqli_num_rows($gotid);
    if(mysqli_num_rows($gotid) == 1){
        $row = mysqli_fetch_array($gotid);
        $_SESSION["User"] = $row["Firstname"]." ".$row["Lastname"];

    }
    else{
    }
?>