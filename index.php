<?php
// html tag / title/ head tag 
// css link
include "inc/head.php";


// Nav bar include
include "inc/navbar.php";




if(isset($_GET['page'])){
    $page = $_GET['page'];
    if($page == 'home'){ //home page include
        include "inc/home.php";
    }elseif($page == 'profile'){ //profile page include
        include "inc/profile.php";
    }
}else{
    // home page
    include "inc/home.php";
}



// footer and closing body and html tags
include "inc/footer.php";
?>