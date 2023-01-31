<?php
// html tag / title/ head tag 
// css link
include "inc/run/connect.php";
include "inc/pages/head.php";
include "inc/run/functions.php";


// Nav bar include
include "inc/pages/navbar.php";




if(isset($_GET['page'])){
    $page = $_GET['page'];
    if($page == 'home'){ //home page include
        include "inc/pages/home.php";
    }elseif($page == 'profile'){ //profile page include
        include "inc/pages/profile.php";
    }elseif($page == 'login'){ //profile page include
        include "inc/pages/login.php";
    }elseif($page == 'register'){ //profile page include
        include "inc/pages/register.php";
    }
}else{
    // home page
    include "inc/pages/home.php";
}







// footer and closing body and html tags
include "inc/pages/footer.php";


?>