<?php
    // Start the session
    session_start();
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
    <title>Your Shop</title>
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
                header( "location: /~pluem/db_demo/index.php");
                exit(0);
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
                    <a class="dropdown-item" href="~pluem/db_demo/notification.php">alert</a>
                    <a class="dropdown-item" href="/~pluem/db_demo/Editprofile.php">Editprofile</a>
                    <div class="text-center"><form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                        <button name="logout" type="submit" class="btn btn-outline-dark">Logout</button>
                    </form></div>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/~pluem/db_demo/">Back to Customer mode</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="/~pluem/db_demo/index.php">
            <input name="keyword" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
  </div> <?php }?>
</nav>

    <?php
        if(isset($_POST['logout'])){
            session_unset();
            session_destroy();
            echo "You are already logout.";
            header( "location: /~pluem/db_demo/index.php");
            exit(0);
        }
    ?>
<div class="container">
<?php
    include("connection.php");
    $id = $_GET["shopid"];
    //echo $id;
    $gtshop = "SELECT * FROM Shop WHERE ShopID=$id";
    $typeresult = mysqli_query($conn, $gtshop);
    if(mysqli_num_rows($typeresult) == 1){
        $row = mysqli_fetch_array($typeresult);
        $user = $_SESSION["UserID"];
        if($user != $row["Owner"]){
            header( "location: /~pluem/db_demo/index.php");
            exit(0);
        }
        else{
            echo "<h1>".$row["ShopName"]."</h1>";
        }
    }
    else{
        header( "location: /~pluem/db_demo/index.php");
        exit(0);
    }
    //echo $types;
?>
    <table class="table table-striped">
  
    <tbody>
    <tr>
        <th scope="row">ShopName</th>
        <td><?php echo $row["ShopName"]; ?></td>
        <form method="POST">
        <td><input type="text" name="newshopname" value="<?php echo $row["ShopName"]; ?>"></td>
        <td><button type="submit" name="rename">Rename</button></td>
        </form>
        <?php
            if(isset($_POST["rename"])){
                $name = $_POST["newshopname"];
                $edit = "UPDATE Shop SET ShopName='$name' WHERE ShopID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    //header( "location: /~pluem/db_demo/index.php");
                    //exit(0);
                    header( "refresh: 2;");
                    exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
    </tr>
    <tr>
      <th scope="row">Rate</th>
      <td><?php echo $row["Rate"]; ?></td>
      <th>Balance</th>
      <td><?php echo $row["Balance"]; ?></td>
    </tr>
    <tr>
        <th scope="row">Telephone</th>
        <td><?php echo $row["ShopTel"]; ?></td>
        <form method="POST">
        <td><input type="text" name="newtelephone" value="<?php echo $row["ShopTel"]; ?>"></td>
        <td><button type="submit" name="retel">Change telephone Number</button></td>
        </form>
        <?php
            if(isset($_POST["retel"])){
                $tel = $_POST["newtelephone"];
                $edit = "UPDATE Shop SET ShopTel='$tel' WHERE ShopID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    //header( "location: /~pluem/db_demo/index.php");
                    //exit(0);
                    header( "refresh: 2;");
                    exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
    </tr>
    <tr>
        <th scope="row">Bank Account</th>
        <td><?php echo $row["BankACC"]; ?></td>
        <form method="POST">
        <td><input type="text" name="newBank" value="<?php echo $row["BankACC"]; ?>"></td>
        <td><button type="submit" name="rebank">Change Bank Account</button></td>
        </form>
        <?php
            if(isset($_POST["rebank"])){
                $bankacc = $_POST["newBank"];
                $edit = "UPDATE Shop SET BankACC='$bankacc' WHERE ShopID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    //header( "location: /~pluem/db_demo/index.php");
                    //exit(0);
                    header( "refresh: 2;");
                    exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
    </tr>
    <tr>
        <th scope="row">Type</th>
        <?php 
            $typecode = $row["ShopType"];
            $gottype = "SELECT * FROM ProductType WHERE TypeID=$typecode";
            $gotid = mysqli_query($conn,$gottype);
            //echo mysqli_num_rows($gotid);
            if(mysqli_num_rows($gotid) == 1){
                //echo "GOTot";
                $data = mysqli_fetch_array($gotid);
                $nametype = $data["TypeName"];
            }
            $gttype = "SELECT * FROM ProductType";
            $typeresult = mysqli_query($conn, $gttype);
            $types = "";
            while($r = mysqli_fetch_assoc($typeresult)){
                //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
                $types = $types. '<option value="'.$r["TypeID"] . '">' . $r["TypeName"] . "</option>";
            }
        ?>
        <td><?php echo $nametype; ?></td>
        <form method="POST">
        <td><select name="shoptype">
            <?php
                echo $types;            
            ?>
            </select><br></td>
        <td><button type="submit" name="retype">Change Shop Type</button></td>
        </form>
        <?php
            if(isset($_POST["retype"])){
                $newt = $_POST["shoptype"];
                $edit = "UPDATE Shop SET ShopType='$newt' WHERE ShopID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    //header( "location: /~pluem/db_demo/index.php");
                    //exit(0);
                    header( "refresh: 2;");
                    exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
    </tr>
    </tbody>
    </table>       
</div>
<div class="container">
    <h2>Stocks</h2>
    <button onclick="window.location.href='/~pluem/db_demo/shop_admin/add_product.php?shopid=<?php echo $id;?>'">
      Add Product
    </button>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Productname</th>
                <th scope="col">Size</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $gtshop = "SELECT Product.ProductID AS ProductID ,Product.ProductName AS ProductName, Product.Size AS Size, Product.Quantity AS Quantity, Product.ProductPrice AS Price, ProductType.TypeName AS TypeName FROM Product 
                        INNER JOIN ProductType ON Product.TypeID = ProductType.TypeID
                        WHERE Product.ShopID=$id";
            $productresult = mysqli_query($conn, $gtshop);

            while($d = mysqli_fetch_assoc($productresult)){
                //echo $d['ProductName'];
        ?>
                <tr>
                    <th scope="row"><?php echo $d["ProductName"]?></th>
                    <td><?php echo $d["Size"]?></td>
                    <form method="POST" action="updateproduct.php">
                    <td><input type="number" name="nnq" value="<?php echo $d["Quantity"]?>"></td>
                    <td><input type="number" name="nnp" value="<?php echo $d["Price"]?>"></td>
                    <td><button type="submit" name="pid" value="<?php echo $d["ProductID"];?>">Edit</button></td>
                    </form>
                </tr>
        <?php
            }
        ?>
        
</table>
</div>
<div class="container">
            <h2>Request</h2>
            <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Productname</th>
                <th scope="col">Size</th>
                <th scope="col">Quantity</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            $gtshop = "SELECT Product.ProductID AS ProductID ,Product.ProductName AS ProductName, Product.Size AS Size, SUM(Request.Quantity) AS Quantity FROM Product 
                        INNER JOIN Request ON Product.ProductID = Request.ProductID
                        WHERE Product.ShopID=$id AND Request.ShopAlert=1
                        GROUP BY Product.ProductID, Product.ProductName, Product.Size";
            $productresult = mysqli_query($conn, $gtshop);

            while($d = mysqli_fetch_assoc($productresult)){
                //echo $d['ProductName'];
        ?>
                <tr>
                    <th scope="row"><?php echo $d["ProductName"]?></th>
                    <td><?php echo $d["Size"];?></td>
                    <td><?php echo $d["Quantity"];?></td>
                    <form method="POST" action="alertignore.php">
                    <td><button type="submit" name="piid" value="<?php echo $d["ProductID"];?>">Edit</button></td>
                    </form>
                </tr>
        <?php
            }
        ?>
        
</table>
</div>
</html>