<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Food Recipe</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
<header class="header">
   <section class="flex">
    <a href="index.php" class="logo">😋Food Recipes😋</a>
   
      <nav class="navbar">
         <a href="index.html">Home</a>
         <a href="about.html">About</a>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


         
    <?php
                // Check if the user is logged in (you should have a session variable set)
                if (isset($_SESSION['user_name'])) {
                    $userName = $_SESSION['user_name'];
                    // Display the user's name next to the icon
                    echo '<a href="profile.php"><i class="fas fa-user"></i> ' . $userName . '</a>';
                } else {
                    // Display the login icon and link
                    echo '<a href="http://localhost/recipes/Login.php"><i class="fas fa-user"></i> Login</a>';
                }
                ?>

    </nav>

   </section>
    </header>
    <div class="content">
    <h1> "Where Flavor Meets Imagination: <br>Your Culinary Adventure Begins Here!"</h1><br>
                <h1><a href="state.html">CLICK HERE</h1>
  </div>
                
            </div>
       </body>
</html>