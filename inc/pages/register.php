<section class="login">
    <form action="inc/run/action.php" class="loginform" method="POST">
        <div class="headline"><h3>Register ICE at SLTC</h3></div>
        <div class="form-field-container">
            <div class="form-input-content">
                <label for="registerfirstname">First Name</label>
                <input type="text" id="registerfirstname" name="registerfirstname" autocomplete="off" placeholder="Enter First Name" required>
            </div>
            <div class="form-input-content">
                <label for="registerlastname">Last Name</label>
                <input type="text" id="registerlastname" name="registerlastname" autocomplete="off" placeholder="Enter Last Name" required>
            </div>
            <div class="form-input-content">
                <label for="registerdob">Date of Birth</label>
                <input type="date" max="2005-12-31" min="1990-01-01" id="registerdob" name="registerdob" autocomplete="off" placeholder="Enter Last Name" required>
            </div>
            <div class="form-input-content">
                <label for="registersltcindex">SLTC Index Number</label>
                <input type="text" id="registersltcindex" name="registersltcindex" autocomplete="off" placeholder="Enter SLTC Index Number" required>
            </div>
            <div class="form-input-content">
                <label for="registerbatch">Batch</label>
                <input type="text" id="registerbatch" name="registerbatch" autocomplete="off" placeholder="Batch" required>
            </div>
            <div class="form-input-content">
                <label for="registerphone">Phone Number (+94712345678)</label>
                <input type="tel" id="registerphone" name="registerphone" autocomplete="off" placeholder="+947XXXXXXXX" value="+947"required pattern="[+]{1}[9]{1}[4]{1}[7]{1}[0-9]{8}" maxlength="12">
            </div>
            <div class="form-input-content">
                <label for="registeremail">Email (Personal)</label>
                <input type="email" id="registeremail" name="registeremail" autocomplete="off" placeholder="Enter Personal Email" required>
            </div>
            <div class="form-input-content">
                <label for="registeremailsltc">Email (SLTC)</label>
                <input type="email" id="registeremailsltc" name="registeremailsltc" autocomplete="off" placeholder="Enter SLTC Email" required>
            </div>

            <div class="form-input-content">
                <label for="registerusername">Username</label>
                <input type="text" id="registerusername" name="registerusername" autocomplete="off" placeholder="Enter Username or Email" required>
            </div>

            <div class="form-input-content">
                <label for="registerpassword">Password</label>
                <input type="password" id="registerpassword" name="registerpassword" placeholder="Enter Password" required>
            </div>

            <div class="form-input-content">
                <button type="submit" name="registersubmit" value="register">Register</button>
            </div>

        </div>
        <div class="form-bottom">
            <a href="#">If you already have an account login here!</a>
        </div>
    </form>
</section>
