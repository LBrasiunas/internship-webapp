<?php
    $title = 'Sign up';
    include "header.php";
    require_once "usersController.php"
?>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8 bg-light rounded border border-dark border-2 my-auto">
            <form action="register.php" method="post" class="needs-validation" novalidate>
                <div class="text-center m-5">
                    <h2>Sign up</h2>
                </div>
                <div class="form-floating m-3">
                    <input type="text" class="form-control" placeholder="Name" required minlength="2" maxlength="30" name="name">
                    <div class="invalid-feedback">
                        Please write a name (2-30 letters).
                    </div>
                    <label class="form-label">Name</label>
                </div>
                <div class="form-floating m-3">
                    <input type="text" class="form-control" placeholder="Surname" required minlength="2" maxlength="30" name="surname">
                    <div class="invalid-feedback">
                        Please write a surname (2-30 letters).
                    </div>
                    <label class="form-label">Surname</label>
                </div>
                <div class="form-floating m-3">
                    <input type="email" class="form-control" placeholder="name@example.com" required minlength="5" maxlength="100" name="email">
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
                <div class="form-floating m-3">
                    <input type="password" class="form-control" placeholder="Password" required minlength="5" maxlength="128" name="cpassword">
                    <div class="invalid-feedback">
                        Please write a correct password containing at least 5 symbols.
                    </div>
                    <label class="form-label">Repeat password</label>
                </div>
                <div class="text-center">
                    <button id="validate"  type="submit" name="register" class="btn btn-outline-dark btn-lg mb-3">Sign up</button>
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
    if (isset($_POST['register'])){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['cpassword'];
        $userContr = new UsersController();
        $returnValue = $userContr->createUser($name, $surname, $email, $password, $confirmPassword);
        if($returnValue == "fields_not_full"){
            callAlert("Not all fields are occupied. Please fill in all of the fields in the form.", "alert-danger");
        }
        elseif($returnValue == "passwords_no_match"){
            callAlert("Passwords do not match! Try again.", "alert-danger");
        }
        elseif($returnValue == "user_exists"){
            callAlert("User with the specified email already exists! Try a different email address.", "alert-danger");
        }
        else{
            callAlert("User created successfully.", "alert-success");
            header("Refresh:2; url=index.php");
        }
    }
?>

</body>
</html>

