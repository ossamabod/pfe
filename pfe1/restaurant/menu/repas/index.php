<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Plats</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .container {
      margin-top: 50px;
    }
    .card {
      margin-bottom: 20px;
    }
    .card-header {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Plats</h1>
    <div class="row">
      <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lol";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        // Retrieve the meal ID from the URL or form submission
if (isset($_GET["repas_id"])) {
  $repas_id = $_GET["repas_id"];
}
else {
  die("No repas ID specified.");
}

// Retrieve the meal name from the database
$sql = "SELECT name FROM repas WHERE id = $repas_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $meal_name = $row["name"];
} else {
  die("repas not found.");
}

        // Retrieve the list of ingredients for the meal from the database
        $sql = "SELECT i.id, i.name FROM plats i JOIN meal_repas mi ON i.id = mi.meal_id WHERE mi.repas_id = $repas_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $meal_id = $row["id"];
            $meal_name = $row["name"];
            // $meal_description = $row["description"];
            // Retrieve the image path for the meal from the database
            //$sql2 = "SELECT image_path FROM images WHERE id = (SELECT image_id FROM meal_image WHERE meal_id = $meal_id)";
            // $result2 = $conn->query($sql2);
            // if ($result2->num_rows > 0) {
            //   $row2 = $result2->fetch_assoc();
            //   //$image_path = $row2["image_path"];
            // }
            // else {
            //   $image_path = "default.jpg";
            // }
            // Display the meal information in a Bootstrap card
            echo "<div class='col-md-4'>
                    <div class='card'>
                      <div class='card-body'>
                        <h5 class='card-title'>$meal_name</h5>
                        <a href='plat/index.php?meal_id=$meal_id' class='btn btn-primary'>Choose Ingredients</a>
                      </div>
                    </div>
                  </div>";
          }
        }
        else {
          echo "No meals found.";
        }
        // Close the database connection
        $conn->close();
      ?>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
