<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_panel.css">
    <style>
        /* Add this style to limit image dimensions */
        .recipe img {
            max-width: 400px;
            height: 200px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>

    <div class="recipe-list">
    <?php
    // Connect to the database (update with your credentials)
    $conn = mysqli_connect("localhost", "root", "", "recipe_website");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['refuse'])) {
        // Check if the "Refuse" button was clicked
        $recipeIdToRefuse = $_POST['recipe_id'];

        // Delete the recipe from the database
        $deleteSql = "DELETE FROM recipes WHERE id = '$recipeIdToRefuse'";

        if (mysqli_query($conn, $deleteSql)) {
            echo '<div class="success-message" style="font-size: 40px; background-color: #FF5733; color: #fff; padding: 20px; text-align: center;">';
            echo '<p>The recipe has been refused and deleted.</p>';
            echo '</div>';
        } else {
            echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
        }
    }

    // Retrieve pending recipes
    $sql = "SELECT * FROM recipes WHERE status = 'pending'";
    $result = mysqli_query($conn, $sql);

    // Check if there are pending recipes
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="recipe">';
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<p>Ingredients: ' . $row['ingredients'] . '</p>';
            echo '<p>Instructions: ' . $row['instructions'] . '</p>';

            // Encode image URL before displaying
            $imageUrl = htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8');

            // Display the encoded image URL
            echo '<div class="recipe-image"><img src="' . $imageUrl . '" alt="' . $row['title'] . '"></div>';
            echo '<p>Video: ' . $row['video'] . '</p>';

            // Display the current state
            echo '<p>State: ' . $row['state'] . '</p>';

            // Add a dropdown box for selecting the state
            echo '<form method="post" action="approve_recipe.php">';
            echo '<input type="hidden" name="recipe_id" value="' . $row['id'] . '">';

            // Include the original state as a hidden field
            echo '<input type="hidden" name="original_state" value="' . $row['state'] . '">';

            // Create a dropdown box with state options
            echo '<label for="state">Change State: </label>';
            echo '<select name="new_state" id="new_state">';
            echo '<option value=""></option>';
            echo '<option value="Bihar">Bihar</option>';
            echo '<option value="Karnataka">Karnataka</option>';
            echo '<option value="Punjab">Punjab</option>';
            echo '<option value="Tamil Nadu">Tamil Nadu</option>';
            echo '<option value="Kerala">Kerala</option>';
            echo '<option value="Rajasthan">Rajasthan</option>';
            echo '<option value="Maharashtra">Maharashtra</option>';
            echo '<option value="Andra Pradesh">Andra Pradesh</option>';
            // Add more state options here as needed
            echo '</select>';
            
            // Add the approve and refuse buttons
            echo '<button type="submit" name="approve">Approve</button>';
            echo '<button type="submit" name="refuse">Refuse</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        // Display a message when no pending recipes are found
        echo '<p>No pending recipes found.</p>';
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    </div>

    <!-- Add CSS styling here -->

</body>
</html>
