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
            //echo "<h1>".$row["ShopName"]."</h1>";
        }
    }
    else{
        header( "location: /~pluem/db_demo/index.php");
        exit(0);
    }
    $gttype = "SELECT * FROM ProductType";
    $typeresult = mysqli_query($conn, $gttype);
    $types = "";
    while($r = mysqli_fetch_assoc($typeresult)){
        //echo "id " .$row["TypeID"]. " name ".$row["TypeName"]."<br>";
        $types = $types. '<option value="'.$r["TypeID"] . '">' . $r["TypeName"] . "</option>";
    }
?>
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
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div> <?php }?>
</nav>
<body>
<div class="container">
    <h2>Add Product</h2>
    <form action="add_product.php?shopid=<?php echo $id?>" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br><br>
        <label for="ProductName">ProductName:</label>
        <input type="text" name="ProductName">
        <br><br>
        <label for="ProductPrice">ProductPrice:</label>
        <input type="text" name="ProductPrice">
        <?php echo "<br><br>" ?>    
        <label for="Quantity">Quantity:</label>
        <input type="text" name="Quantity">
        <?php echo "<br><br>" ?>
        <label for="Size">Size:</label>
        <input type="text" name="Size">
        <?php echo "<br><br>" ?>
        <label for="Color">Color:</label>
        <input type="text" name="Color">
        <?php echo "<br><br>" ?>
        <label for="TypeID">Select Type</label>
        <select name="TypeID">
            <?php
                echo $types;            
            ?>
        </select>
        <?php echo "<br><br>" ?>
        <input type="submit" name="submit" value="submit">
    </form>
</div>
<?php
    $target_dir = "picturepath/productpicture/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } 
        else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        $ProductName = $_POST["ProductName"]; $ProductPrice = (int)$_POST["ProductPrice"]; 
        $Quantity = (int)$_POST["Quantity"]; $ShopID = $id;
        $Size = $_POST["Size"]; $Color = $_POST["Color"];
        $TypeID = (int)$_POST["TypeID"];
        if($ProductName=="ALL"){
            $Price = 0; $TypeID = 0; 
            $Quantity = 0; $ShopID = 0;
            $Size = "0"; $Color = "0";
                
        }
        $sql = "INSERT INTO Product (ProductName, ProductPrice, Quantity, ShopID, Size, Color, TypeID, productpicture)
                VALUES ('$ProductName',$ProductPrice,$Quantity,$ShopID,'$Size','$Color',$TypeID,'$target_file')";
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        //echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
    //echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    }
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        //echo "can't add product";
    }
    $conn->close();
?>

</body>
</html>