<?php
    $title = 'Password reset';
    include "header.php";
    require_once "usersController.php"
?>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8 bg-light rounded border border-dark border-2 my-auto">
            <form action="password_reset_primary.php" method="post" class="needs-validation" novalidate>
                <div class="text-center m-5">
                    <h2>Password reset</h2>
                </div>
                <div class="form-floating m-3">
                    <input type="email" class="form-control" placeholder="name@example.com" required minlength="5" maxlength="100" name="email">
                    <div class="invalid-feedback">
                        Please write a correct email containing at least 5 symbols.
                    </div>
                    <label class="form-label">Email address</label>
                </div>
                <div class="text-center">
                    <button id="validate" type="submit" name="start_reset" class="btn btn-outline-dark btn-lg mb-3">Send</button>
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
<?php
    include "footer.php";
    if (isset($_POST['start_reset'])){
        $email = $_POST['email'];
        $userContr = new UsersController();
        $returnValue = $userContr->startPassReset($email);
        if($returnValue == "success"){
            callAlert("Password reset email successfully sent! Check your inbox.", "alert-success");
        }
        elseif($returnValue == "invalid_email"){
            callAlert("User with specified email does not exist! Try a different email address.", "alert-danger");
        }
        else{
            callAlert("Error: " .$returnValue, "alert-danger");
        }
    }
?>
</body>
</html>
