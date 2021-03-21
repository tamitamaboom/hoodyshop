<?php
    //start session
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='styleindex.css'/>
    <title>Wearing Platform</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/~pluem/db_demo/">Platform name</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="/~pluem/db_demo/">Home <span class="sr-only">(current)</span></a>
        </li>
        <?php
            if(!$_SESSION['UserID']){
        ?>
            <li class="nav-item">
                <a class="nav-link" href="/~pluem/db_demo/hellonewcustomer.php/">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/~pluem/db_demo/login.php/">Login</a>
            </li>
        </ul>
        <?php        
            }
            else{
        ?>
            <li class="nav-item">
                <a class="nav-link" href="/~pluem/db_demo/shop_admin/new_shop.php/">New Shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/~pluem/db_demo/shop_admin/">My Shop</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["User"];?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/~pluem/db_demo/notification.php">alert</a>
                    <a class="dropdown-item" href="cart.php">Cart</a>
                    <a class="dropdown-item" href="/~pluem/db_demo/Editprofile.php">Editprofile</a>
                    <div class="text-center"><form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <button name="logout" type="submit" class="btn btn-outline-dark">Logout</button>
                    </form></div>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/~pluem/db_demo/shop_admin">Seller mode</a>
                </div>
            </li>
        </ul>
        
<?php }?>
    <form class="form-inline my-2 my-lg-0" method="GET" action="/~pluem/db_demo/index.php">
            <input name="keyword" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
<?php
    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        echo "You are already logout.";
        header( "location: /~pluem/db_demo/index.php");
        exit(0);
    }
?>
</nav>

<body>

<?php
    $cart = $_POST["checkout"];
    //echo $cart;
    include("shop_admin/connection.php");
    $custid = $_SESSION["UserID"];
    $order = $_POST["checkout"];
    $scart = "SELECT *
            FROM Orders
            WHERE OrderID = $order AND AcceptDate IS NULL";
    $gotcart = mysqli_query($conn,$scart);
    if(mysqli_num_rows($gotcart) == 0){
        header( "location: /~pluem/db_demo/index.php");
        exit(0);
    }
    else{
        while($roww = $gotcart->fetch_assoc()){
            $tmp = $roww["OrderID"];
        ?>
        <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Size</th>
                    <th scope="col">Price(x1)</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $prod = "SELECT Product.ProductID AS PID, Product.ProductName AS PPN,  Product.Size AS PDS, SUM(OrderProduct.Quantity) AS OPQ, Product.ProductPrice AS PPP 
                            FROM Product INNER JOIN OrderProduct ON Product.ProductID = OrderProduct.ProductID
                            WHERE OrderProduct.OrderID=$tmp
                            GROUP BY Product.ProductID, Product.ProductName, Product.Size, Product.ProductPrice
                        ";
                $gotprod = mysqli_query($conn, $prod);
                $pass = 0;
                $moneyp = 0;
                $fail = array();
                while($ppd = $gotprod->fetch_assoc()){
                    $ptemp = $ppd["PID"];
                    $stock = "SELECT Quantity FROM Product WHERE ProductID=$ptemp";
                    $stock = mysqli_query($conn, $stock);
                    $stock = mysqli_fetch_array($stock);
                    $stock = $stock["Quantity"];
                    if($stock>=$ppd["OPQ"]) {
                        $pass++;
                        $moneyp += (($ppd["OPQ"])*($ppd["PPP"]));
                        $ns = $stock-$ppd["OPQ"];
                        //echo $ns;
                        $ns = "UPDATE Product SET Quantity=$ns WHERE ProductID=$ptemp";
                        
                        if ($conn->query($ns) === TRUE) {
                            echo "Record updated successfully";
        
                        } 
                        else {
                            echo "Error updating record: " . mysqli_error($conn);
                        }
            ?>
                        
                        <tr>
                            <th scope="col"><?php echo $ppd["PPN"]; ?></th>
                            <td><?php echo $ppd["PDS"]; ?></td>
                            <td><?php echo $ppd["PPP"]; ?></td>
                            <td><?php echo $ppd["OPQ"]; ?></td>
                        </tr>
                            <?php
                    }
                    else{
                        array_push($fail,$ppd);
                        include("bringoutcart.php");
                        $gotcart = mysqli_query($conn,$scart);
                        
                    }
                }
                $time = time();
                if($pass == 0){
                    echo "<script>alert('ไม่มีสินค้าที่คุณสามรถสั่งซื้อได้');</script>"; 
                    $time = -($time);
                }
                $gotcart = mysqli_query($conn,$scart);
                if(mysqli_num_rows($gotcart) == 0){
                    header( "location: /~pluem/db_demo/index.php");
                    exit(0);
                }
                else{
                    $roww = mysqli_fetch_array($gotcart);
                    $shopID = $roww["ShopID"];
                    $orID = $shopID;
                    include("updateorder.php");
                    $moneymm = $roww["OrderPrice"];
                    $gotshop = "SELECT Balance FROM Shop WHERE ShopID=$shopID";
                    $gotshop = mysqli_query($conn,$gotshop);
                    $gotshop = mysqli_fetch_array($gotshop);
                    $gotshop = $gotshop["Balance"];
                    $moneymm = $moneymm+$gotshop;
                    $update = "UPDATE Shop SET Balance=$moneymm WHERE ShopID=$shopID";
                    if ($conn->query($update) === TRUE) {
                        echo "Record updated successfully";
                        
                    } 
                    else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                $update = "UPDATE Orders SET SpendID=1,DeliveryID=0,TrackCode=21293,AcceptDate=$time WHERE OrderID=$tmp";
                if ($conn->query($update) === TRUE) {
                    echo "Record updated successfully";
                    
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
                
                ?>
                
                <thead class="thead-light">
                <tr>
                    <th scope="col">Balance</th>
                    <th scope="col"></th>
                    <th scope="col"><?php echo $moneyp; ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <?php
                    

                }
            }
        }   
             
    

?>
            
            </tbody>
        </table>



        </div>

        <?php
    if(sizeof($fail)>0){
        ?>
        <div class="container">
            <h4>รายการที่ไม่สำเร็จสามารถ request ผู้ขายได้ภาพหลัง</h4>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Size</th>
                    <th scope="col">Price(X1)</th>
                    <th scope="col">Quantity</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($fail as $ls){
                    ?>
                        <tr>
                        <th scope="row"><?php echo $ls["PPN"];?></th>
                        <td><?php echo $ls["PDS"];?></td>
                        <td><?php echo $ls["OPQ"];?></td>
                        <td><?php echo $ls["PPP"];?></td>
                    <?php
                }
            ?>
    
            </tbody>
        </table>
        </div>
        <?php
    }

?>
    </body>  
</html>




