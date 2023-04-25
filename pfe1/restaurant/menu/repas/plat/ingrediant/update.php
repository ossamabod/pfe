<?php
// Connection variables
$host = "localhost";
$username = "root";
$password = "";
$database = "lol";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update operation

if (isset($_POST['update'])) {
    // Get image data
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageType = $_FILES['image']['type'];

    // Get name data
    $name = $_POST['name'];

    // Get image extension
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Valid file extensions
    $validExtensions = array("jpg", "jpeg", "png");

    // Check if the file extension is valid
    if (in_array($imageExt, $validExtensions)) {
        // Delete the old image from the server
        $oldImagePath = 'uploads/' . $row['image_path'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        // Generate a unique file name
        $imageNameNew = uniqid() . '.' . $imageExt;

        // Upload the file to the server
        $imagePath = 'uploads/' . $imageNameNew;
        move_uploaded_file($imageTmpName, $imagePath);

        // Update the data in the database
        $sql = "UPDATE images SET name=?, image_path=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $name, $imageNameNew, $_POST['id']);
        mysqli_stmt_execute($stmt);

        // Redirect to the index page
        header('Location: index.php');
    } else {
        // Display an error message
        echo "Invalid file type. Only JPG, JPEG, and PNG file types are allowed.";
    }
}

// Select data for the specified ID
$sql = "SELECT * FROM images WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if data was found
if (mysqli_num_rows($result) > 0) {
    // Display the form with the data
    $row = mysqli_fetch_assoc($result);
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required>
        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*">
        <br>
        <input type="submit" name="update" value="Update Entry">
    </form>
    <?php
} else {
    // Display an error message
    echo "Entry not found.";
}
?>
