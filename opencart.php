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
    $cart = $_POST["cart"];
    include("shop_admin/connection.php");
    $custid = $_SESSION["UserID"];
    $scart = "SELECT *
            FROM Orders
            WHERE CartID = $cart AND AcceptDate IS NULL";
    $gotcart = mysqli_query($conn,$scart);
    if(mysqli_num_rows($gotcart) == 0){
        echo "<H3>ว่างเปล่าแบบนี้ไม่เคยสั่งของสินะ</H3>";
    }
    else{
        while($roww = $gotcart->fetch_assoc()){
            $tmp = $roww["OrderID"];
            //echo $tmp;
            //echo "<br>";
        ?>
        <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Product</th>
                    <th></th>
                    <th scope="col">Size</th> 
                    <th scope="col">Price(x1)</th>
                    <th scope="col">Quantity</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                $prod = "SELECT OrderProduct.LogID AS OPL, Product.ProductID AS PID, Product.ProductName AS PPN, Product.ProductPrice AS PPP, Product.Size AS PDS, OrderProduct.Quantity AS OPQ, Product.productpicture AS PPIC, OrderProduct.OrderID AS OID
                        FROM Product INNER JOIN OrderProduct ON Product.ProductID = OrderProduct.ProductID
                        WHERE OrderProduct.OrderID=$tmp";
                $gotprod = mysqli_query($conn, $prod);
                while($ppd = $gotprod->fetch_assoc()){
            ?>
                        <tr>
                            <th scope="col"><?php echo $ppd["PPN"]; ?></th>
                            <td class="w-25"><img src="shop_admin/<?php echo $ppd["PPIC"] ;?>" style="width:30%; size: 25%;" class="image"></td>
                            <td><?php echo $ppd["PDS"]; ?></td>
                            <td><?php echo $ppd["PPP"]; ?></td>
                            <td><form action="<?php echo $_SERVER["PHP_SELF"] ;?>" method="POST">
                                <input type="number" name="nq" value="<?php echo $ppd["OPQ"]; ?>">
                                <button type="submit" name="edq" value="<?php echo $ppd["OPL"]; ?>">Edit</button>
                            </form></td>
                            <td><a href="<?php echo $_SERVER["PHP_SELF"];?>?action=delete&id1=<?php echo $ppd["OID"]; ?>&id2=<?php echo $ppd["PID"]; ?>"><span class="text-danger">Remove</span></a></td>
                        </tr>
                            <?php
                }
                ?>
                <thead class="thead-light">
                <tr>
                    <th scope="col">Balance</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"><?php echo $roww["OrderPrice"];?></th>
                    <th></th>
                    <th scope="col"><select>
                        <option>Free Delivery</option>
                    </select></th>
                </tr>
                </thead>
                <thead class="thead-light">
                <tr>
                    <th scope="col"><form>
                    <label>Coupon Code</label>
                    <input type="text">
                </form></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th></th>
                    <th scope="col"><form method="POST" action="checkout.php">
                        <button name="checkout" value="<?php echo $roww["OrderID"];?>" type="submit" class="btn btn-success">CheckOut</button>
                    </form></th>
                </tr>
                </thead>
                <?php
            }
        ?>
        </tbody>
    </table>
        <?php    
        }
             if(isset($_POST["edq"])){
                $logid = $_POST["edq"];
                $newquantity = $_POST["nq"];
                //echo $orID. " ".$newquantity;
                $orID = "SELECT OrderID FROM OrderProduct WHERE LogID = $logid";
                $orID = mysqli_query($conn,$orID);
                //echo mysqli_num_rows($gotid);
                if(mysqli_num_rows($orID) == 1){
                    $orID = mysqli_fetch_array($orID);
                    $orID = $orID["OrderID"];
    
                }
                $upd = "UPDATE OrderProduct SET Quantity=$newquantity WHERE LogID=$logid";
                if ($conn->query($upd) === TRUE) {
                    //echo "Record updated successfully";
                    //header( "location: /~pluem/db_demo/index.php");
                    //exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
                include("updateorder.php");
                header( "location: /~pluem/db_demo/cart.php");
                exit(0);
             } 
             if(isset($_GET["action"]))
             {
                 if($_GET["action"] == "delete")
                 {
                    $iD1 = $_GET["id1"];
                    $iD2 = $_GET["id2"];
                    $delete_order = false;
                    $sql1 = "DELETE FROM OrderProduct WHERE OrderID = $iD1 AND ProductID = $iD2";
                    if (mysqli_query($conn, $sql1)) {
                        //echo "Record deleted successfully";
                        $orID = $iD1;
                        $delete_order = true;
                        //include("updateorder.php");
                    } else {
                        //echo "Error deleting record: " . mysqli_error($conn);
                    }
                    $sql2 = "DELETE FROM Orders WHERE OrderID = $orID";
                    if (mysqli_query($conn, $sql2)) {
                        //echo "Record deleted successfully";
                    } else {
                        //echo "Error deleting record: " . mysqli_error($conn);
                    }
                 }
                 //include("updateorder.php");
                 header( "location: /~pluem/db_demo/opencart.php");
                 exit(0);
             }
?>

        </div>

</body>
</html>