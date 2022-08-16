<?php 
include 'config.php'; 
$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['uploadFile']['name'];
    $product_image_tmp_name = $_FILES['uploadFile']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image ;

    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'Please fill the field'; 
    }else {
        $update ="UPDATE cartdb SET name='$product_name', price='$product_price', image='$product_image'
        WHERE id= $id";
        $upload = mysqli_query($conn, $update);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name,$product_image_folder); 
            $message[] = "Product has been added Successfully"; 

        }else {
            $message[] = "There is a problem, Nothing is added !"; 
        }
    }
}; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="new.css">
    <title>Update Page</title>
</head>
<body>
     

     <?php
        if (isset($message)) {
            foreach($message as $message){
                echo '<span class="message">'.$message.'</span>';
            }
        }
        ?>

     <div class="product-display">

        <div class="add-product-form-container center">

           
              <?php
               $select = mysqli_query($conn, "SELECT * FROM cartdb WHERE id=$id");
               while($row = mysqli_fetch_assoc($select)){
              ?>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" >
            <h3>Update Product Page </h3>
            <input type="text" placeholder= "  Enter product name " value="<?php echo $row['name'];?>" name="product_name" class="box">
            <input type="number" placeholder= "  Enter price name " value="<?php echo $row['price'];?>" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="uploadFile" class="box">
            <input type="submit" class="btn" name="update_product" value="Update a product">
            <a href="admin_page.php" class="back-btn">Go Back</a>
        
        </form>
               

        <?php }; ?>
        </div>
     </div>
    
</body>
</html>