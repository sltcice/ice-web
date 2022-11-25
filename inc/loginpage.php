<?php if(!(isset($_SESSION['user_data']))){ ?>
<section class="login-reg">
    <div class="headline">
        <h4>SLTC BRS - <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "පුරනය වන්න"; }else{echo 'LOGIN';} ?><br>
    <?php 
    // echo "<pre>";
    // print_r($_SESSION['user_data']);
    // echo "</pre>";
    if(isset($_SESSION['register_data'])){if(empty($_SESSION['register_data']['errormsg'])){echo $_SESSION['register_data']['msg'];}}
    ?></h4>
    </div>
    <div class="error">
        <h4><?php if(isset($_GET['page']) and isset($_GET['error']) ){if($_GET['error'] == 'wc'){echo "Wrong Credentials!";}elseif($_GET['error'] == 'nl'){if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ඔබ දැනටමත් ලියාපදිංචි වී ඇත්නම් කරුණාකර පුරනය වන්න!"; }else{echo "Login First, if you are already registered !";}}else{echo "Please login if you are already registered!";}}elseif(!empty($_SESSION['register_data']['errormsg'])){echo $_SESSION['register_data']['errormsg'];}else{if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ඔබ දැනටමත් ලියාපදිංචි වී ඇත්නම් කරුණාකර පුරනය වන්න!"; }else{echo "Login First, if you are already registered !";}}?></h4>
    </div>
    <div class="log-reg-div">
        <div class="login">
            <form action="inc/action.php?login" method="post">
                <h3><?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ඇතුල් වන්න"; }else{echo 'Login';} ?></h3>
                <label for="lusername">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "පරිශීලක නාමය හෝ ඊ-මෙයිල් ලිපිනය"; }else{echo 'Username or Email';} ?>
                </label>
                <input type="text" name="lusername" id="lusername" required>
                <label for="lpassword">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "මුරපදය"; }else{echo 'Password';} ?>
                </label>
                <input type="password" name="lpassword" id="lpassword" required>
                <button type="submit" value="login" name="login"><?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ඇතුල් වන්න"; }else{echo 'Login';} ?></button>
            </form>

        </div>
        <div class="register">
            <form action="inc/action.php?register" method="post">
                <h3><?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ලියාපදිංචිවන්න"; }else{echo 'Register';} ?></h3>
                <label for="rusername">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "පරිශීලක නාමය "; }else{echo 'Username (Enter your student no. exactly as it is in your student ID card)';} ?>
                </label>
                <input type="text" name="rusername" id="rusername" required>

                <label for="remail">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ඊමේල් ලිපිනය(කරුණාකර ඔබගේ පෞද්ගලික ඊමේල් ලිපිනය ඇතුලත් කරන්න.)"; }else{echo 'Email (Enter your personal e-mail accurately)';} ?>
                </label>
                <input type="email" name="remail" id="remail" required>

                <label for="phone">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "දුරකතන අංකය"; }else{echo 'Mobile Number';} ?>
                </label>
                <input type="tel" id="phone" name="phone" pattern="[0][7][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]" placeholder="<?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "උදා"; }else{echo 'Ex';} ?>: 0712345678" required>
                
                <label for="rpassword">
                <?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "මුරපදය"; }else{echo 'Password';} ?>
                </label>
                <input type="password" name="rpassword" id="rpassword" required>
                <button type="submit" value="register" name="register"><?php if(isset($_SESSION['lan']) and $_SESSION['lan'] == 'si'){echo "ලියාපදිංචිවන්න"; }else{echo 'Register';} ?></button>
            </form>

        </div>
    </div>
</section>
<?php }else{
    header("Location: index.php?page=home");
} ?>