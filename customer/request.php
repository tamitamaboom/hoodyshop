<?php
    //start session
    session_start()

?>
<?php    
    include("shop_admin/connection.php");
    $custid = $_SESSION["UserID"];
                    $cart = "SELECT *
                            FROM Customer
                            WHERE CustomerID = $custid";
                    $gotcart = mysqli_query($conn,$cart);
                    if(mysqli_num_rows($gotcart) == 0){
                        header( "location: /~pluem/db_demo/login.php");
                        exit(0);
                    }
    $uid = $_SESSION["UserID"];
    $id = $_GET["callrequest"];
    $quan = $_GET["quantity"];
    $arq = "INSERT INTO Request (CustomerID, ProductID, Quantity) VALUES ($uid, $id, $quan)";
        if ($conn->query($arq) === TRUE) {
            echo "New record created successfully";
            header( "location: /~pluem/db_demo/");
            exit(0);
        } 
        else {
            echo "Error: " . $upl . "<br>" . $conn->error;
        }
?>