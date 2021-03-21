<?php
    include("shop_admin/connection.php");
    //echo "form update orid = ".$orID;
    $gotallp = "SELECT OrderProduct.OrderID AS OID, Product.ProductID AS PPID, Product.ProductPrice AS PPP, OrderProduct.Quantity AS OQ
                FROM Product INNER JOIN OrderProduct ON Product.ProductID = OrderProduct.ProductID
                WHERE OrderProduct.OrderID = $orID;
                ";
    $price = 0;
    $uresult = mysqli_query($conn, $gotallp);
    while($urow = mysqli_fetch_assoc($uresult)){
        //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
        $price = $price+ ($urow["OQ"]*$urow["PPP"]);
    }
    //echo $price;
    $update = "UPDATE Orders SET OrderPrice='$price' WHERE OrderID=$orID";
    if ($conn->query($update) === TRUE) {
        echo "Record updated successfully";
        
    } 
    else {
        echo "Error updating record: " . mysqli_error($conn);
    }
?>
