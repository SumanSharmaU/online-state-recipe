<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database (update with your credentials)
    $conn = mysqli_connect("localhost", "root", "", "recipe_website");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get data from the form
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url']; // Image URL input
    $video = $_POST['video'];

    // Extract the YouTube video ID from the URL
    $video_id = '';
    if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video, $matches)) {
        $video_id = $matches[1];
    } elseif (preg_match('/youtu.be\/([^\\?\\&]+)/', $video, $matches)) {
        $video_id = $matches[1];
    }

    // Convert the YouTube link to the embedded format
    $embedded_video_url = "https://www.youtube.com/embed/$video_id";

    // Initialize the image filename
    $image_filename = '';

    // Check if an image file was uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/"; // Specify your upload directory
        $image_filename = $target_dir . basename($_FILES['image']['name']);

        // Upload the image
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_filename)) {
            // Image upload success
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Use either the uploaded image or the image URL
    $image_to_insert = !empty($image_filename) ? $image_filename : $image_url;

    // Get the state from the form
    $state = $_POST['state'];

    // Use prepared statements with parameter binding to insert data
    $sql = "INSERT INTO recipes (title, ingredients, instructions, image_url, video, state, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())";

    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssss", $title, $ingredients, $instructions, $image_to_insert, $embedded_video_url, $state);

    if (mysqli_stmt_execute($stmt)) {
        echo '<div class="success-message" style="font-size: 40px; background-color: #4CAF50; color: #fff; padding: 100px; margin: 150px; text-align: center;">';
        echo '<p>Your recipe has been successfully submitted!</p>';
        echo '<p>It will be reviewed by the admin.</p>';
        echo '</div>';
        // Redirect to dashboard.php after 1 second
        echo '<meta http-equiv="refresh" content="1;url=dashboard.php">';
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
