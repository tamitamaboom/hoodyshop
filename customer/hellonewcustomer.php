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
<?php
    include("shop_admin/connection.php");
    $gttype = "SELECT * FROM ProductType";
    $typeresult = mysqli_query($conn, $gttype);
    $types = "";
    while($row = mysqli_fetch_assoc($typeresult)){
        //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
        $types = $types. '<option value="'.$row["TypeID"] . '">' . $row["TypeName"] . "</option>";
    }
    //echo $types;
?>

<body>
    <div class="container">
        <h2>Register</h2><br><br>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
		    <div class="row">
                <div class="col">
                    <label for="firstname">Firstname</label>
		            <input type="text" name="firstname"><br>
                </div>
                <div class="col">
                    <label for="lastname">Lastname</label>
		            <input type="text" name="lastname"><br>
                </div>
            </div>
            <label for="usermail">Email</label>
            <input type="email" name="usermail"><br>
        	<label for="password">Password</label>
	        <input type="password" name="password"><br>
	        <label for="rpassword">Re-entry Password</label>
		    <input type="password" name="rpassword"><br>
            <label for="custtel">Telephone</label>
	        <input type="text" name="custtel"><br>
	        <label for="add">Address</label>
	        <input type="text" name="add"><br>
            <label for="city">City</label>
	        <input type="text" name="city"><br>
            <label for="province">Province</label>
	        <input type="text" name="province"><br>
            <label for="postcode">Postcode</label>
	        <input type="text" name="postcode"><br>
            <label for="interest1">Select your 1st interest</label>
            <select name="interest1">
            <?php
                echo $types;            
            ?>
	        </select><br>
	        <label for="interest2">Select your 2nd interest</label>
            <select name="interest2">
            <?php
                echo $types;            
            ?>
	        </select><br>
            <label for="interest3">Select your 3rd interest</label>
            <select name="interest3">
            <?php
                echo $types;            
            ?>
	        </select><br>
	        <input type="submit" name="submit" value="submit">
        </form>
    <?php
        if(isset($_POST['submit'])){
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["usermail"];
            $telephone = $_POST["custtel"];
            $address = $_POST["add"];
            $city = $_POST["city"];
            $province = $_POST["province"];
            $postcode = $_POST["postcode"];
            $interest1 = $_POST["interest1"];
            $interest2 = $_POST["interest2"];
            $interest3 = $_POST["interest3"];
            $passwd = $_POST["password"];
            //echo $firstname." ". $lastname." ". $email." ". $telephone." ". $city." ". $province." ". $postcode." ". $interest1." ". $interest2." ". $interest3;
            if($passwd==$_POST["rpassword"]){
                $up = "INSERT INTO Customer (Firstname, Lastname, Email, CustTel, CustAddress, City, Province, Postcode, Interest1, Interest2, Interest3, Password)
                    VALUES ('$firstname', '$lastname', '$email', '$telephone', '$address', '$city', '$province', '$postcode', '$interest1', '$interest2', '$interest3', '$passwd')";
                if ($conn->query($up) === TRUE) {
                    echo "New record created successfully";
                    header( "location: /~pluem/db_demo/index.php");
                    exit(0);
                } 
                else {
                    echo "Error: " . $upl . "<br>" . $conn->error;
                }
              
                  $conn->close();
                }
                else{
                    echo "Recheck your Password";
                }
            }
        ?>
    </div>
</body>

</html>
