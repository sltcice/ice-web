<section class="verify">
    <?php if(isset($_GET['verifyemail'])){
        // header("Location: index.php?page=account&verifyemail");
    } ?>
    <div class="book-form">
        <form action="inc/action.php" method="post">
            <h3>Verify youre email address.</h3>
            <label for="username">
                Username
            </label>
            <input type="text" name="username" id="username" required <?php if(isset($_SESSION['register_data']['username'])){echo "value='".$_SESSION['register_data']['username']."'";}elseif(isset($_SESSION['user_data']['username'])){echo "value='".$_SESSION['user_data']['username']."'";}?>>
            <label for="brdate">
                Email
            </label>
            <input type="email" name="email" id="email" required <?php if(isset($_SESSION['register_data']['email'])){echo "value='".$_SESSION['register_data']['email']."'";}elseif(isset($_SESSION['user_data']['email'])){echo "value='".$_SESSION['user_data']['email']."'";}?>>

            <label for="otp">
                6 Digits Verify Code
            </label>
            <input type="number" maxlength="6" size="6" name="otp" id="otp" required>
            <button type="submit" value="verify" name="verify">Verify</button>
        </form>
    </div>
</section>