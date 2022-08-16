
<?php include 'config.php';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['uploadFile']['name'];
    $product_image_tmp_name = $_FILES['uploadFile']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image ;

    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'Please fill the field'; 
    }else {
        $insert = "INSERT INTO cartdb(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name,$product_image_folder); 
            $message[] = "Product has been added Successfully"; 

        }else {
            $message[] = "There is a problem, Nothing is added !"; 
        }
    }
}; 

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn , "DELETE FROM cartdb WHERE id=$id");
    header('location:admin_page.php'); 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new.css">
    <title>Admin Page</title>
</head>
<body> 

    <?php
      if (isset($message)) {
        foreach($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
      }
    ?>
    
  <div class="container">
    <div class="add-product-form-container">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
        <h3>Add Product Page </h3>

        <input type="text" placeholder= "  Enter product name "  name="product_name" class="box">
        <input type="number" placeholder= "  Enter price name "  name="product_price" class="box">
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="uploadFile" class="box">
        <input type="submit" class="btn" name="add_product" value="Add a product">
    
    </form>
    </div>

    <?php
       $select = mysqli_query($conn , "SELECT*FROM cartdb");
    ?>
    

     <div class="product-display">
     <table class="product-display-table">
         <thead>
            <tr>
                <th>product image</th>
                <th>product name</th>
                <th>product price</th>
                <th colspan="2">action</th>
            </tr>
         </thead>

       <?php
        //    $result = mysqli_fetch_assoc($select);
            while ($row = mysqli_fetch_assoc($select)){        
                 $row['name']; 
       ?>
       <tr>
                <td><img src="uploaded_img/<?php echo $row["image"]; ?>" height="100" alt=""></td>
                <td><?php echo $row["name"]; ?> </td>
                <td><?php echo $row["price"]; ?> $</td>
                <td >
                    <a href="admin_update.php?edit=<?php echo $row["id"]; ?>" class="btn"><i class="fas fa-edit"> edit</i></a>
                    <a href="admin_page.php?delete=<?php echo $row["id"]; ?>" class="btn"><i class="fas fa-trash"> delete</i></a>
                </td>
            </tr>

       <?php  };  ?>

     </table>
       
     </div>

    
  </div>

 

</body>
</html>