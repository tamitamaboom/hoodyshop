<?php
    //echo $_POST["nnq"].", ".$_POST["nnp"].", ".$_POST["pid"];
    include("connection.php");
    $quantity = $_POST["nnq"];
    $price = $_POST["nnp"];
    $productid = $_POST["pid"];

    $update = "UPDATE Product SET Quantity=$quantity, ProductPrice=$price WHERE ProductID=$productid";
    if ($conn->query($update) === TRUE) {
        echo "Record updated successfully";
        //header( "location: /~pluem/db_demo/index.php");
        //exit(0);
        include("mailing.php");
        header( "location: /~pluem/db_demo/shop_admin");
        exit(0);
    } 
    else {
        echo "Error updating record: " . mysqli_error($conn);
    }
?>