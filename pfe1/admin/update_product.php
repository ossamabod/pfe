<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

// UPDATE MEAL
if(isset($_POST['update_plat'])){
   $id = $_POST['id'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $image = $_FILES['image'];
   $image_name = $image['name'];
   $image_size = $image['size'];
   $image_tmp_name = $image['tmp_name'];
   $image_folder = '../uploaded_img/'.$image_name;

   $select_products = $conn->prepare("SELECT * FROM `plats` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if(empty($image_name)){ // if the image is not updated
         $update_product = $conn->prepare("UPDATE `plats` SET name=?, description=?, category=?, price=? WHERE id=?");
         $update_product->execute([$name, $description, $category, $price, $id]);
         $message[] = 'product updated!';
      }else{ // if the image is updated
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $update_product = $conn->prepare("UPDATE `plats` SET name=?, description=?, category=?, price=?, image_path=? WHERE id=?");
            $update_product->execute([$name, $description, $category, $price, $image_folder, $id]);
            $message[] = 'product updated!';
         }
      }
   }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update repas</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update repas section starts  -->

<section class="update-repas">

   <h1 class="heading">update repas</h1>

   <?php
      $update_id = $_GET['update'];
      $show_repass = $conn->prepare("SELECT * FROM `plats` WHERE id = ?");
      $show_repass->execute([$update_id]);
      if($show_repass->rowCount() > 0){
         while($fetch_repass = $show_repass->fetch(PDO::FETCH_ASSOC)){  
   ?>
    <form action="" method="POST" enctype="multipart/form-data">
    
      <span>update name</span> 
      <input type="text" required placeholder="enter repas name" name="name" maxlength="100" class="box" value="<?= $fetch_repass['name']; ?>">
      
      <span>update description</span>
      <input type="text" required placeholder="enter repas description" name="description" maxlength="100" class="box" value="<?= $fetch_repass['description']; ?>">

      <span>update image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="product.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no repass added yet!</p>';
      }
   ?>

</section>

<!-- update repas section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>