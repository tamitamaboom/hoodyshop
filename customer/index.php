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
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col" style="width:18%">ProductName</th>
        <th scope="col" style="width:8%">ProductPrice</th>
        <th scope="col" style="width:8%">Quantity</th>
        <th scope="col" style="width:12%">ShopID</th>
        <th scope="col" style="width:8%">Size</th>
        <th scope="col" style="width:8%">Color</th>
        <th scope="col" style="width:10%">Type</th>
        <th scope="col" style="width:20%">Product Picture</th>
        <th scope="col" style="width:8%">Action</th>
    </tr>
    </thead>
  <tbody>
<?php
    include("shop_admin/connection.php");
    if($keyword == ""){
        $sql = "SELECT Product.ProductID AS PID ,Product.ProductName AS Pname, Product.ProductPrice AS Pprice, Product.Quantity AS Pquan, Shop.ShopName AS Sshop, Product.Size AS Psize, Product.Color AS Pcolor, ProductType.TypeName AS Ptype, Product.productpicture AS Ppic 
                FROM ((Product 
                INNER JOIN Shop ON Product.ShopID = Shop.ShopID)
                INNER JOIN ProductType ON Product.TypeID = ProductType.TypeID)";
    }
    else{
        $sql = "SELECT Product.ProductID AS PID ,Product.ProductName AS Pname, Product.ProductPrice AS Pprice, Product.Quantity AS Pquan, Shop.ShopName AS Sshop, Product.Size AS Psize, Product.Color AS Pcolor, ProductType.TypeName AS Ptype, Product.productpicture AS Ppic 
                FROM ((Product 
                INNER JOIN Shop ON Product.ShopID = Shop.ShopID)
                INNER JOIN ProductType ON Product.TypeID = ProductType.TypeID)
                WHERE Product.ProductName LIKE '%".$keyword."%'";
    }    
    
    $result = mysqli_query($conn, $sql);
        //echo "pass";
        //$i = 0;
        if($result->num_rows > 0){
            while($roww = $result->fetch_assoc()){
                //echo $i." ";
                //$i++;
                if($roww["Pname"]=="ALL") continue;
                ?>
                    <tr>
                        <th scope="row"><?php echo $roww["Pname"] ;?></th>
                        <td><?php echo $roww["Pprice"] ;?></td>
                        <td><?php echo $roww["Pquan"] ;?></td>
                        <td><?php echo $roww["Sshop"] ;?></td>
                        <td><?php echo $roww["Psize"] ;?></td>
                        <td><?php echo $roww["Pcolor"] ;?></td>
                        <td><?php echo $roww["Ptype"] ;?></td>
                        <td><img src="shop_admin/<?php echo $roww["Ppic"] ;?>" style="width:70%; size: 25%;" class="image"></td>
                        <td>
                            <?php
                                if($roww["Pquan"]>0){
                                    ?>
                                    <form action="buyproduct.php" method="GET">
                                        <input type="number" name="quantity" value="1">
                                        <button type="submit" name="callorder" value="<?php echo $roww["PID"];?>">Add to Cart</button>
                                    <?php
                                }
                                else{
                                    ?>
                                    <form action="request.php" method="GET">
                                        <input type="number" name="quantity" value="1">
                                        <button type="submit" name="callrequest" value="<?php echo $roww["PID"];?>">Request</button>
                                    <?php
                                }
                            ?>
                        </form></td>
                    </tr>
                
                <?php
            }
        }
        else{
            echo "zero";
        }
?>
  </tbody>
</table>
</body>
</html>