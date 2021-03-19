<?php
    include("connection.php");
    $gtpdn = "SELECT ProductName FROM Product WHERE ProductID=$productid";
    $gtpdn = mysqli_query($conn,$gtreq);
    $gtpdn = mysqli_fetch_array($gtpdn);
    $gtpdn = $gtpdn["ProductName"];
    $text = "สินค้า". $gtpdn. "ที่คุณสนใจมีการปรับให้มี". $quantity ."ชิ้น ในราคา". $price;
    $gtreq = "SELECT RequestID ,CustomerID, Quantity FROM Request WHERE ProductID=$productid AND Status=1";
    $gtreq = mysqli_query($conn,$gtreq);
    while($r = mysqli_fetch_assoc($gtreq)){
        //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
        $rqid = $r["RequestID"];
        $person = $r["CustomerID"];
        $up = "INSERT INTO Mailbox (UserID, Text)
            VALUES ('$person', '$text')";
        if ($conn->query($up) === TRUE) {
            //echo "Mailgo";
        } 
        else {
            //echo "Error: " . $upl . "<br>" . $conn->error;
        }
        //$conn->close();
        if($quantity>=$r["Quantity"]){
            $update = "UPDATE Request SET Status=0 WHERE RequestID=$rqid";
            if ($conn->query($update) === TRUE) {
                //echo "Record updated successfully";
                //header( "location: /~pluem/db_demo/index.php");
                //exit(0);
        
            } 
            else {
                //echo "Error updating record: " . mysqli_error($conn);
    }
        }
        
    }
?>