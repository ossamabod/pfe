<?php
// database connection
$conn = mysqli_connect("localhost", "root", "", "lol");

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// delete image and name based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // retrieve image filename from database
    $result = mysqli_query($conn, "SELECT image_path FROM images WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $filename = $row['image_path'];
    
    // delete image file from server
    if (unlink("uploads/$filename")) {
        // delete record from database
        $sql = "DELETE FROM images WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting image file";
    }
}
    // Redirect to the index page
    header('Location: index.php');
// close connection
mysqli_close($conn);
?>
