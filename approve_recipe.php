<?php
// Connect to the database (update with your credentials)
$conn = mysqli_connect("localhost", "root", "", "recipe_website");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['approve'])) {
    $recipeId = $_POST['recipe_id'];
    $newState = $_POST['new_state']; // New state selected by admin

    // Get the original state of the recipe
    $originalState = $_POST['original_state'];

    // Update the recipe's status to 'approved' and optionally assign a new state
    if (!empty($newState)) {
        $sql = "UPDATE recipes SET status = 'approved', state = '$newState' WHERE id = $recipeId";
    } else {
        // If no new state is selected, retain the original state
        $sql = "UPDATE recipes SET status = 'approved' WHERE id = $recipeId";
        $newState = $originalState; // Set new state to the original state
    }

    if (mysqli_query($conn, $sql)) {
        echo '<div class="success-message" style="font-size: 40px; background-color: #4CAF50; color: #fff; padding: 100px; margin: 150px; text-align: center;">';
        echo "<p>Recipe approved and assigned to $newState successfully.</p>";
        // Redirect to admin_panel.php after 0.5 seconds
        echo '<meta http-equiv="refresh" content="0.5;url=admin_panel.php">';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['refuse'])) {
    // Check if the "Refuse" button was clicked
    $recipeIdToRefuse = $_POST['recipe_id'];

    // Delete the recipe from the database
    $deleteSql = "DELETE FROM recipes WHERE id = '$recipeIdToRefuse'";

    if (mysqli_query($conn, $deleteSql)) {
        // Redirect back to the admin panel after successful deletion
        header('Location: admin_panel.php');
        exit();
    } else {
        echo "Error: " . $deleteSql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
