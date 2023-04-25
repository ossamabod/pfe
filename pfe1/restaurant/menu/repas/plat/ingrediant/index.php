<!DOCTYPE html>
<html>
<head>
    <title>Ingredient</title>
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Ingredient</h1>
    <h2>Add New Entry</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        <br>
        <input type="submit" name="create" value="Add Entry">
    </form>

    <h2>Current Entries</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        
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

        // Create operation
        if (isset($_POST['create'])) {
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
                // Generate a unique file name
                $imageNameNew = uniqid() . '.' . $imageExt;

                // Upload the file to the server
                $imagePath = 'uploads/' . $imageNameNew;
                move_uploaded_file($imageTmpName, $imagePath);

                // Insert the data into the database
                $sql = "INSERT INTO images (name, image_path) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'ss', $name, $imageNameNew);
                mysqli_stmt_execute($stmt);

                // Redirect to the index page
                header('Location: index.php');
            } else {
                // Display an error message
                echo "Invalid file type. Only JPG, JPEG, and PNG file types are allowed.";
            }
        }
        
        // Select all data from the table
            $sql = "SELECT * FROM images";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// Output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						echo "<td>".$row["name"]."</td>";
                        echo "<td><img src='uploads/" .$row["image_path"]. "' height='50'></td>";
						echo "<td><a href='update.php?id=".$row["id"]."'>Edit</a> | <a href='delete.php?id=".$row["id"]."' onclick='return confirm(\"Are you sure you want to delete this entry?\")'>Delete</a></td>";
                        echo "</tr>";
					}
                   

				} else {
					echo "<tr><td colspan='4'>No entries found</td></tr>";
				}
				$conn->close();
			?>
