<link rel="stylesheet" href="Views/navbarStyle.css">
<nav class="navbar navbar-light navbar-expand-lg text-dark position-fixed">
    <a href="#" class="navbar-brand mx-3"><img class="h-10" id="logo" src="images/logo.png" alt="Hexa Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapsing">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapsing">
        <ul class="navbar-nav ml-auto mr-4">
            <li class="nav-item <?php if (isset($CURRENT_PAGE) && $CURRENT_PAGE == 'index'){ echo 'active'; } ?>"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item <?php if (isset($CURRENT_PAGE) && $CURRENT_PAGE == 'mens'){ echo 'active'; } ?>"><a href="mens.php" class="nav-link">Men's</a></li>
            <li class="nav-item <?php if (isset($CURRENT_PAGE) && $CURRENT_PAGE == 'womens'){ echo 'active'; } ?>"><a href="womens.php" class="nav-link">Women's</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Kids's</a></li>
            <!-- <li class="nav-item"><a href="#" class="nav-link">Pages</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Explore</a></li> -->
            <li class="nav-item">
           
                <?php 
                    if (isset($_SESSION['fname'])){
                        echo '<div class="dropleft">
                        
                        <a class="dropdown-toggle nav-link" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        <img src="'.$profile_url.'" id="profile_image" alt=".">
                            '.$_SESSION['fname']." ".$_SESSION['lname'].'
                        </a>
                        <div class="dropdown-menu">
                            <a href="myCart.php" class="dropdown-item">My Cart</a>
                            <a href="editProfile.php" class="dropdown-item">Edit Profile</a>
                            <a href="changePassword.php" class="dropdown-item">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                        </div>';
                    } else {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>';
                    }


                ?>
            </li>



            <!-- <li class="nav-item"><a href="#" class="nav-link">Login</a></li> -->

        </ul>
    </div>
</nav>

