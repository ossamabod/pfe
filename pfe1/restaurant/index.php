<!DOCTYPE html>
<html>
<head>
	<title>Restaurants</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Custom CSS -->
	<style>
		body {
			padding: 50px;
		}
		h1 {
			margin-bottom: 30px;
			text-align: center;
		}
		.restaurant-link {
			display: block;
			font-size: 24px;
			margin-bottom: 10px;
			color: #007bff;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Restaurants</h1>
        <?php
	// Connect to database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "lol";
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	// Retrieve restaurants from database
	$sql = "SELECT * FROM restaurants";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // Output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        echo "<a href='menu/index.php?menu_id=".$row["id"]."' class='restaurant-link'>".$row["name"]."</a>";
	    }
	} else {
	    echo "0 results";
	}

	mysqli_close($conn);
	?>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html