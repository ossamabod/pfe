<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  

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
if (isset($_GET["meal_id"])) {
    $meal_id = $_GET["meal_id"];
}
else {
    die("No meal ID specified.");
}

// Retrieve the meal name from the database
$sql = "SELECT name FROM plats WHERE id = $meal_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $meal_name = $row["name"];
} else {
    die("Meal not found.");
}

// Retrieve the list of ingredients for the meal from the database
$sql = "SELECT i.id, i.name, i.image_path FROM images i JOIN meal_ingredient mi ON i.id = mi.ingredient_id WHERE mi.meal_id = $meal_id";
$result = $conn->query($sql);

// Display the meal name and list of ingredients to the user
echo "<h1>$meal_name</h1>";
echo "<form method='post'>";
echo "<input type='hidden' name='meal_id' value='$meal_id'>";
echo "<h2>Ingredients:</h2>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<td><img src='ingrediant/uploads/" .$row["image_path"]. "' height='50'></td>";
        echo "<input type='checkbox' name='ingredients[]' value='" . $row["id"] . "'>" . $row["name"] . " <br> ";
    }
} else {
    echo "No ingredients found.";
}

echo "<input type='submit' value='Submit'>";
echo "</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the array of selected ingredient IDs
    $selected_ingredients = $_POST["ingredients"];

    
    // Insert the selected ingredients into the database
    foreach ($selected_ingredients as $ingredient_id) {
    $sql = "INSERT INTO orders (meal_id, ingredients_id) VALUES ('$meal_id', '$ingredient_id')";
    if ($conn->query($sql) === FALSE) {
        die("Error: " . $sql . "<br>" . $conn->error);
    }
}

echo "Order placed successfully.";


}

// Close the database connection
$conn->close();
?>
</body>
</html>