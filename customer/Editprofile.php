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
    $id = $_SESSION["UserID"];
    //echo $id;
    $getuserdata = "SELECT * FROM Customer WHERE CustomerID = $id ";
    $gotid = mysqli_query($conn,$getuserdata);
    if(mysqli_num_rows($gotid) == 1){
        //echo 'yeahitone';
        $data = mysqli_fetch_array($gotid);
        //echo $data;
        $firstname = $data["Firstname"];
        $lastname = $data["Lastname"];
        $email = $data["Email"];
        $telephone = $data["CustTel"];
        $address = $data["CustAddress"];
        $city = $data["City"];
        $province = $data["Province"];
        $postcode = $data["Postcode"];
        $Interest1 = $data["Interest1"];
        $Interest2 = $data["Interest2"];
        $Interest3 = $data["Interest3"];
        $passwd = $data["Password"];
        //echo $firstname. $lastname;
    }
    else{
        echo "Username or password not found";
    }
?>
<body>
    <div class="container">
    <h2>Edit</h2>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" value="<?php echo $firstname?>">
        <input type="submit" name="fname" value="Edit Firstname">
        <?php
            if(isset($_POST['fname'])){
                $firstname = $_POST["firstname"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Firstname='$firstname' WHERE CustomerID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    include("shop_admin/updatesession.php");
                    header( "refresh: 2;");
                    exit(0);
                    
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
        <br>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" value="<?php echo $lastname?>">
        <input type="submit" name="lname" value="Edit Lastname"><br>
        <?php
            if(isset($_POST['lname'])){
                $lastname = $_POST["lastname"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Lastname='$lastname' WHERE CustomerID=$id";
                if ($conn->query($edit) === TRUE) {
                    echo "Record updated successfully";
                    include("shop_admin/updatesession.php");
                    header( "refresh: 2;");
                    exit(0);
                } 
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        ?>
        <label for="password">New password</label>
        <input type="password" name="password" value="<?php echo $passwd?>"><br>
        <input type="submit" name="pwd" value="Edit Password"><br>
        <?php
            if(isset($_POST['pwd'])){
                $password = $_POST["password"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Password='$password' WHERE CustomerID=$id";
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
        <label for="custtel">Telephone</label>
        <input type="text" name="custtel" value="<?php echo $telephone?>">
        <input type="submit" name="etel" value="Edit Telephone Number"><br>
        <?php
            if(isset($_POST['etel'])){
                $telephone = $_POST["custtel"];
                //echo $firstname;
                $edit = "UPDATE Customer SET CustTel='$telephone' WHERE CustomerID=$id";
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
        <label for="add">Address</label>
        <input type="text" name="add" value="<?php echo $address?>">
        <input type="submit" name="eadd" value="Edit Address"><br>
        <?php
            if(isset($_POST['eadd'])){
                $Address = $_POST["add"];
                //echo $firstname;
                $edit = "UPDATE Customer SET CustAddress='$Address' WHERE CustomerID=$id";
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
        <label for="city">City</label>
        <input type="text" name="city" value="<?php echo $city?>"><br>
        <input type="submit" name="ecity" value="Edit City"><br>
        <?php
            if(isset($_POST['ecity'])){
                $city = $_POST["city"];
                //echo $firstname;
                $edit = "UPDATE Customer SET City='$city' WHERE CustomerID=$id";
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
        <label for="province">Province</label>
        <input type="text" name="province" value="<?php echo $province?>">
        <input type="submit" name="epro" value="Edit Province"><br>
        <?php
            if(isset($_POST['epro'])){
                $province = $_POST["province"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Province='$province' WHERE CustomerID=$id";
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
        <label for="postcode">Postcode</label>
        <input type="text" name="postcode" value="<?php echo $postcode?>"><br>
        <input type="submit" name="ePost" value="Edit Postcode"><br>
        <?php
            if(isset($_POST['ePost'])){
                $postcode = $_POST["postcode"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Postcode='$postcode' WHERE CustomerID=$id";
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
        <label for="interest1">Select your 1st interest</label>
        <select name="interest1">
            <?php
                echo $types;            
            ?>
        </select>
        <input type="submit" name="ei1" value="Edit 1st Interest"><br>
        <?php
            if(isset($_POST['ei1'])){
                $Interest1 = $_POST["interest1"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Interest1='$Interest1' WHERE CustomerID=$id";
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
        <label for="interest2">Select your 2nd interest</label>
        <select name="interest2">
            <?php
                echo $types;            
            ?>
        </select>
        <input type="submit" name="ei2" value="Edit 2nd Interest"><br>
        <?php
            if(isset($_POST['ei2'])){
                $Interest1 = $_POST["interest2"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Interest2='$Interest2' WHERE CustomerID=$id";
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
        <label for="interest3">Select your 3rd interest</label>
        <select name="interest3">
            <?php
                echo $types;            
            ?>
        </select>
        <input type="submit" name="ei3" value="Edit 3rd Interest"><br>
        <?php
            if(isset($_POST['ei3'])){
                $Interest3 = $_POST["interest3"];
                //echo $firstname;
                $edit = "UPDATE Customer SET Interest3='$Interest3' WHERE CustomerID=$id";
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
    </form>
    </div>
    
    
</body>
</html>