<?php
session_start();

// Check if the user is logged in and display their username if available
if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Food Recipe</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
<header class="header">
   <section class="flex">
    <a href="index.html" class="logo">😋Food Recipes😋</a>
   
      <nav class="navbar">
         <a href="about.html">About</a>
         <a href="submit_recipe.html">Submit Recipe</a>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

         <!-- Add this part to display the user's name or the "Login" link -->
         <?php
            if (isset($userName)) {
                echo '<a href="profile_update.php">Welcome, ' . $userName . '</a>';
                echo '<a href="index.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
         ?>
         <!-- End of user name display -->

       </nav>
   </section>
    </header>


    <div class="content">
    <h1> "Where Flavor Meets Imagination: <br>Your Culinary Adventure Begins Here!"</h1><br>
    <h1><a href="state.html">CLICK HERE</a></h1>     
  </div>
  </body>
</html>