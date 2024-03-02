<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="foodd.css">
    <title>Recipe Details</title>
</head>
<body>
    <header>
        <h1>Recipe Details</h1>
    </header>

    <div class="wrapper"> <!-- Use the same class name 'wrapper' -->
        <?php
        // Connect to the database (update with your credentials)
        $conn = mysqli_connect("localhost", "root", "", "recipe_website");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the recipe ID from the query string
        $recipeId = $_GET['id'];

        // Retrieve the details of the selected recipe
        $sql = "SELECT * FROM recipes WHERE id = $recipeId";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Display recipe details
            echo '<div class="left">'; // Use the same class name 'left'
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<img class="img-foodd" src="' . $row['image_url'] . '" alt="' . $row['title'] . '">';
            
            // Check if a video URL is provided
            if (!empty($row['video'])) {
                echo '<div class="video-container">';
                echo '<iframe width="560" height="315" src="' . $row['video'] . '" frameborder="0" allowfullscreen></iframe>';
                echo '</div>';
            } else {
                echo '<p>No video available for this recipe.</p>';
            }

            echo '</div>';
            echo '<div class="right">';
            echo '<h1>Ingredients</h1>';
            echo '<textarea class="textarea" id="" cols="30" rows="10">' . $row['ingredients'] . '</textarea>';
            echo '<h3>Steps To Prepare</h3>';
            echo '<textarea class="textarea1" id="" cols="30" rows="10">' . $row['instructions'] . '</textarea>';
            echo '</div>';
        } else {
            echo '<p>Recipe not found.</p>';
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <!-- Add CSS styling here -->

</body>
</html>
