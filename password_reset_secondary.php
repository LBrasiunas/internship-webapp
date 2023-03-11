<?php
    $title = 'Password reset';
    include "header.php";
    require_once "usersController.php";

    if(!$_GET['key'] && !$_GET['token'])
    {
        header("Location: index.php");
    }
    else{
        $email = $_GET['key'];
        $token = $_GET['token'];
        $conn = mysqli_connect("vl103.sofico.cz", "webapp_rh_ordis_cz", "7Zg2Zr8U0vEhgktp", "webapp_rh_ordis_cz");
        $user_check_query = "SELECT * FROM USERS WHERE TOKEN='$token' and EMAIL='$email'";
        $query = mysqli_query($conn, $user_check_query);
        $curDate = date("Y-m-d H:i:s");
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            if($row['EXP_DATE'] >= $curDate){ ?>
                <div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8 bg-light rounded border border-dark border-2 my-auto">
                            <form action="password_reset_secondary.php" method="post" class="needs-validation" novalidate>
                                <div class="text-center m-5">
                                    <h2>Password reset</h2>
                                </div>
                                <input type="hidden" value="<?php echo $email;?>" name="email">
                                <input type="hidden" value="<?php echo $token;?>" name="token">
                                <div class="form-floating m-3">
                                    <input type="password" class="form-control" placeholder="Password" required minlength="5" maxlength="128" name="password">
                                    <div class="invalid-feedback">
                                        Please write a correct password containing at least 5 symbols.
                                    </div>
                                    <label class="form-label">Password</label>
                                </div>
                                <div class="form-floating m-3">
                                    <input type="password" class="form-control" placeholder="Password" required minlength="5" maxlength="128" name="cpassword">
                                    <div class="invalid-feedback">
                                        Please write a correct password containing at least 5 symbols.
                                    </div>
                                    <label class="form-label">Repeat password</label>
                                </div>
                                <div class="text-center">
                                    <button id="validate" type="submit" name="new_password" class="btn btn-outline-dark btn-lg mb-3">Reset</button>
                                </div>
                                <div class="row mb-3 ms-2">
                                    <div class="col text-start">
                                        <h5><label><a href="index.php">Go to login</a></label></h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }
            else { ?>
                <p><h3>This forget password link has already expired.</h3></p>
            <?php }
        }
    }

    include "footer.php";
    if (isset($_POST['new_password'])){
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['cpassword'];
        $userContr = new UsersController();
        $returnValue = $userContr->resetPassword($email, $password, $confirmPassword);
        if($returnValue == "passwords_no_match"){
            callAlert("Passwords do not match! Try again.", "alert-danger");
        }
        if($returnValue == "all_fields_not_full"){
            callAlert("Wrong password input! Try again.", "alert-danger");
        }
        if($returnValue == "success"){
            header("Location: index.php");
        }
        else{
            $link = "https://webapp.rh.ordis.cz/password_reset_secondary.php?key={$email}&token={$token}";
            header("Location: $link");
        }
    }
?>

</body>
</html>

