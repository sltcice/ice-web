<section class="login">
    <form action="inc/run/action.php" class="loginform" method="POST">
        <div class="headline"><h3>Login ICE at SLTC</h3></div>
        <div class="form-field-container">
            <div class="form-input-content">
                <label for="loginusername">Username</label>
                <input type="text" id="loginusername" name="loginusername" autocomplete="off" placeholder="Enter Username or Email" required>
            </div>

            <div class="form-input-content">
                <label for="loginpassword">Password</label>
                <input type="password" id="loginpassword" name="loginpassword" placeholder="Enter Password" required>
            </div>

            <div class="form-input-content">
                <button type="submit" name="loginsubmit" value="login">Login</button>
            </div>

        </div>
        <div class="form-bottom">
            <a href="#">Forgot password?</a>
        </div>
    </form>
</section>
