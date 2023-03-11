<?php
    $title = 'Login';
    include "header.php";
    require_once "usersController.php"
?>

<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8 bg-light rounded border border-dark border-2 my-auto">
                <form action="index.php" method="post" class="needs-validation" novalidate>
                    <div class="text-center m-5">
                        <h2>Login</h2>
                    </div>
                    <div class="form-floating m-3">
                        <input type="text" class="form-control" placeholder="name@example.com" required minlength="5" maxlength="100" name="email">
                        <div class="invalid-feedback">
                            Please write a correct email containing at least 5 symbols.
                        </div>
                        <label class="form-label">Email address</label>
                    </div>
                    <div class="form-floating m-3">
                        <input type="password" class="form-control" placeholder="Password" required minlength="5" maxlength="128" name="password">
                        <div class="invalid-feedback">
                            Please write a correct password containing at least 5 symbols.
                        </div>
                        <label class="form-label">Password</label>
                    </div>
                    <div class="text-center">
                        <button id="validate" type="submit" name="login" class="btn btn-outline-dark btn-lg mb-3">Login</button>
                    </div>
                    <div class="row mb-3">
                        <div class="col text-start ms-3">
                            <h5><label><a href="register.php">Don't have an account? Sign up</a></label></h5>
                        </div>
                        <div class="col text-end me-3">
                            <h5><label><a href="password_reset_primary.php">Forgot password?</a></label></h5>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        include "footer.php";
        if (isset($_POST['login'])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $userContr = new UsersController();
            if(($userContr->login($email, $password)) == "wrong_credentials"){
                callAlert("Wrong credentials! Try again.", "alert-danger");
            }
            session_start();
            $_SESSION['email'] = $email;
        }
    ?>



</body>
</html>
