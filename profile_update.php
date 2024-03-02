<?php
session_start();

// Check if the user is logged in and has a user ID in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('location: login.php');
    exit();
}

// Include your database connection and perform a query to retrieve user data
include 'config.php';

$userID = $_SESSION['user_id'];

// Query to retrieve user data based on their user ID
$selectUser = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$selectUser->execute([$userID]);
$userData = $selectUser->fetch(PDO::FETCH_ASSOC);

// Check if user data was found
if (!$userData) {
    // Handle the case where user data is not found
    echo "User data not found.";
    exit();
}

// Extract user data
$userName = $userData['name'];
$userEmail = $userData['email'];
$userProfilePic = $userData['image']; // Assuming this is the file path or filename of the profile picture

// Check if the user has submitted a profile update form
if (isset($_POST['update_profile'])) {
    // Handle the form submission to update user profile information
    // You can process the form data here and update the database
    // Example: Update user's name and email
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];

    // Perform an SQL UPDATE query to update the user's data in the database
    $updateUser = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $updateUser->execute([$newName, $newEmail, $userID]);

    // Handle profile picture update
    if ($_FILES['new_profile_pic']['error'] == 0) {
        // Define the folder where the profile pictures should be stored
        $uploadFolder = 'profile_pics/';

        // Get the uploaded file's name
        $newProfilePicName = $_FILES['new_profile_pic']['name'];

        // Define the full path where the file should be saved
        $uploadPath = $uploadFolder . $newProfilePicName;

        // Move the uploaded file to the defined path
        if (move_uploaded_file($_FILES['new_profile_pic']['tmp_name'], $uploadPath)) {
            // Profile picture moved successfully, update database
            $updateProfilePic = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            if ($updateProfilePic->execute([$uploadPath, $userID])) {
                // Successfully updated profile picture
                $userProfilePic = $uploadPath; // Update the displayed profile picture
            } else {
                // Error updating database
                echo "Error updating profile picture in the database.";
            }
        } else {
            // Error moving uploaded file
            echo "Error moving uploaded profile picture.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Update</title>
    <link rel="stylesheet" type="text/css" href="styles7.css">
    <!-- Add your CSS styles if needed -->
</head>
<body>
    <h1>Your Profile</h1>

    <!-- Display the user's profile picture -->
    <img src="<?php echo $userProfilePic; ?>" alt="Profile Picture" width="150">

    <h2>Login Details</h2>
    <p><strong>Name:</strong> <?php echo $userName; ?></p>
    <p><strong>Email:</strong> <?php echo $userEmail; ?></p>

    <!-- Add a form for updating profile information -->
    <h2>Update Profile Information</h2>
    <form action="" method="post">
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" value="<?php echo $userName; ?>" required>
        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" value="<?php echo $userEmail; ?>" required>
        <input type="submit" name="update_profile" value="Update Profile">
    </form>

    <!-- Add an option for changing the profile picture -->
    

    <!-- Add other content or functionality as per your requirements -->

</body>
</html>