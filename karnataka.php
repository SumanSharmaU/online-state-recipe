<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes of Karnataka</title>
    <link rel="stylesheet" href="recipe.css">
</head>
<body>
    <header>
        <h1>Recipes of Karnataka</h1>
    </header>

    <section class="content">
        <div class="state_category">
        <?php
        // Connect to the database (update with your credentials)
        $conn = mysqli_connect("localhost", "root", "", "recipe_website");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve approved recipes for Karnataka
        $sql = "SELECT * FROM recipes WHERE status = 'approved' AND state = 'Karnataka'";
        $result = mysqli_query($conn, $sql);

        // Display approved recipes for Karnataka
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="recipe">';
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

    <!-- Add CSS styling here -->

</body>
</html>
