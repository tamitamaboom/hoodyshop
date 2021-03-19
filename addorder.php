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
    include("shop_admin/connection.php");
    //check stock
    $id = $_GET["callorder"];
    $quan = $_GET["quantity"];
    $cart = $_POST["cart"];
    //echo $id." ".$quan." ".$cart;
    if($id!="" && $quan!=""){
        $check="SELECT ShopID, Quantity 
                FROM Product 
                WHERE ProductID = $id";
        $check = mysqli_query($conn,$check);

        if(mysqli_num_rows($check) == 1){
            $check = mysqli_fetch_array($check);
            //echo $check["Quantity"];
            if($check["Quantity"]<$quan){
                echo "ขอโทษที เราไม่มีของให้คุณมากขนาดนั้นหรอก!";
            }
            else{
                $shID = $check["ShopID"];
                //echo $shID;
                $shop ="SELECT * 
                        FROM Orders
                        WHERE ShopID = $shID AND AcceptDate IS NULL AND CartID = $cart";
                $gotshop = mysqli_query($conn,$shop);
                echo mysqli_num_rows($gotshop);
                if(mysqli_num_rows($gotshop) == 0){
                    echo "Make new order";
                    $neworder = "INSERT INTO Orders (CartID, ShopID)
                                VALUES ($cart, $shID)";
                    if ($conn->query($neworder) === TRUE) {
                        echo "New record created successfully";
                        //header( "location: /~pluem/db_demo/index.php");
                        //exit(0);
                    } 
                    else {
                        echo "Error: " . $upl . "<br>" . $conn->error;
                    }
                  
                
                }
                $order ="SELECT * 
                        FROM Orders
                        WHERE ShopID = $shID AND AcceptDate IS NULL AND CartID = $cart";
                $order = mysqli_query($conn,$order);
                if(mysqli_num_rows($order) == 1){
                    $order = mysqli_fetch_array($order);
                    //echo $order["OrderID"];
                    $orID = $order["OrderID"];
                    $aop = "INSERT INTO OrderProduct (OrderID, ProductID, Quantity) VALUES ($orID, $id, $quan)";
                    if ($conn->query($aop) === TRUE) {
                        echo "New record created successfully";
                        include("updateorder.php");
                        header( "location: /~pluem/db_demo/cart.php");
                        exit(0);
                    } 
                    else {
                        echo "Error: " . $upl . "<br>" . $conn->error;
                    }
                }
            }
        }
    }

?>


  
</body>
</html>