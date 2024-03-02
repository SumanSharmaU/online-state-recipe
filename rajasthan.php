<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="approved_recipe.css">
    <title>Recipes of Rajasthan</title>
    <!-- Add any CSS styles or external stylesheets here -->
</head>
<body>
    <header>
        <h2>Recipes of Rajasthan</h2>
    </header>

    <div class="recipe-cards">
    <?php
        // Connect to the database (update with your credentials)
        $conn = mysqli_connect("localhost", "root", "", "recipe_website");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve approved recipes from the database
        $sql = "SELECT * FROM recipes WHERE status = 'approved' AND state = 'Rajasthan'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="recipe-card">';
                echo '<img src="' . $row['image_url'] . '" alt="' . $row['title'] . '">';
                echo '<h2>' . $row['title'] . '</h2>';
                echo '<a href="recipe_details.php?id=' . $row['id'] . '">Click Me</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No approved recipes found.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <!-- Add any additional HTML or styling here -->

</body>
</html>
