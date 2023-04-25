<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" integrity="sha512-xuV8WIOHrjvV7fEz2xrN/k8sYsENs/7xgZdM85Z8VhpWJrVBSe7DEE+QOu2NRXykWj1vJxzwZ3c3+I8CJWQeIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .menu {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .menu a {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    background-color: #F5A623;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    transition: all 0.2s ease-in-out;
  }
  
  .menu a:hover {
    background-color: #FFC500;
    transform: scale(1.05);
  }
  
        </style>
</head>
<body>
    <?php
    // Connect to the database
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "lol";
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    // Retrieve the list of meals from the database
    $query = "SELECT id, name FROM repas ORDER BY name ASC";
    $result = mysqli_query($conn, $query);

    // Output the meal links
    echo "<div class='container'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-6'>";
    echo "<div class='menu'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $repas_id = $row["id"];
        $repas_name = $row["name"];

        echo "<a href='repas/index.php?repas_id=$repas_id' class='btn btn-outline-primary btn-lg mb-3'>$repas_name</a>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Close the database connection
    mysqli_close($conn);

    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js" integrity="sha512-NsPXoUwBRZvN+6U1VKlUd3hLr9KcHdUnmpPbcgIzf8mYwZ36KjJIGAGvhQ2faNVxgKpyjOLlxbpx8lzHr9JlFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
