<?php
    // Start the session
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Add new shop</title>
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

<?php 
    include("connection.php");
    $gttype = "SELECT * FROM ProductType";
    $typeresult = mysqli_query($conn, $gttype);
    $types = "";
    while($row = mysqli_fetch_assoc($typeresult)){
        //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
        $types = $types. '<option value="'.$row["TypeID"] . '">' . $row["TypeName"] . "</option>";
    }
?>
<body>
    <div class="container">
        <h2>Create Shop</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
            <label for="name">Enter your shop name</label>
            <input type="text" name="name"><br>
            <label for="tel">Enter your telephone number</label>
            <input type="text" name="tel"><br>
            <label for="bankacc">Enter your Bank Account Number</label>
            <input type="text" name="bankacc"><br>
            <label for="shoptype">Select your Shoptype</label>
            <select name="shoptype">
            <?php
                echo $types;            
            ?>
            </select><br>
            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    
</body>
<?php
    
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $bank = $_POST['bankacc'];
        $type = $_POST['shoptype'];
        $ownercode = $_SESSION['UserID'];
        $up = "INSERT INTO Shop (Shopname, Shoptel, Shoptype, BankACC, Owner)
            VALUES ('$name', '$tel', '$type', '$bank', '$ownercode')";
        if ($conn->query($up) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $upl . "<br>" . $conn->error;
        }
        $conn->close();
    }
    
    
?>
</html>