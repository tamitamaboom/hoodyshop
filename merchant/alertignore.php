<?php
    include("connection.php");
    $pid = $_POST["piid"];
    $update = "UPDATE Request SET ShopAlert=0 WHERE ProductID=$pid";
            if ($conn->query($update) === TRUE) {
                //echo "Record updated successfully";
                header( "location: /~pluem/db_demo/shop_admin");
                exit(0);
        
            } 
            else {
                echo "Error updating record: " . mysqli_error($conn);
    }
?>