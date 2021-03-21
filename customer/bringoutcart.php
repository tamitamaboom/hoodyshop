<?php
    include("shop_admin/connection.php");
    //echo $ptemp.",".$tmp;
    $tozero = "UPDATE OrderProduct SET Quantity=0 WHERE OrderID=$tmp AND ProductID=$ptemp";
    if ($conn->query($tozero) === TRUE) {
        echo "Record updated successfully";
        
    } 
    else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    $orID = $tmp;
    include("updateorder.php");
?>