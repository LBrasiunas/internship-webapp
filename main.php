<?php
session_start();
$title = "User administration";
include "header.php";
require_once "usersController.php";
$currentEmail = $_SESSION['email'];
if ($currentEmail == NULL) {
    header("Location: index.php");
}
$userContr = new UsersController();
$returnValue = $userContr->seeUser($currentEmail);
if ($returnValue == "user_not_exist") {
    unset($_SESSION['email']);
    header("Location: index.php");
}
if ($currentEmail == "admin") {
    ?>
    <div class="container mt-5 bg-light rounded border border-dark border-2">
        <input type="hidden" value="" name="email">
        <div class="row">
            <h3>User administration</h3>
            <h5><label><a href="index.php">Go back</a></label></h5>
            <hr>
        </div>
        <div class="row">
            <?php $userContr->seeAllUsers(); ?>
        </div>
    </div>
    <div id="continue" class="row"></div>
    <?php
} else { ?>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8 bg-light rounded border border-dark border-2 my-auto">
                <form action="main.php" method="post" class="needs-validation" novalidate>
                    <div class="text-center m-5">
                        <h2>
                            <?php echo "{$currentEmail} management"; ?>
                        </h2>
                    </div>
                    <div class="form-floating m-3">
                        <input type="text" class="form-control" placeholder="Name" required minlength="2" maxlength="30"
                            value="<?php echo $returnValue['FIRST_NAME']; ?>" name="name">
                        <div class="invalid-feedback">
                            Please write a name (2-30 letters).
                        </div>
                        <label class="form-label">Name</label>
                    </div>
                    <div class="form-floating m-3">
                        <input type="text" class="form-control" placeholder="Surname" required minlength="2" maxlength="30"
                            value="<?php echo $returnValue['LAST_NAME']; ?>" name="surname">
                        <div class="invalid-feedback">
                            Please write a surname (2-30 letters).
                        </div>
                        <label class="form-label">Surname</label>
                    </div>
                    <div class="text-center">
                        <button id="validate" type="submit" name="change_details"
                            class="btn btn-outline-dark btn-lg mb-3">Change</button>
                    </div>
                    <div class="form-floating m-3">
                        <input type="password" class="form-control" placeholder="Password" minlength="5" maxlength="128"
                            name="password">
                        <div class="invalid-feedback">
                            Please write a correct password containing at least 5 symbols.
                        </div>
                        <label class="form-label">Password</label>
                    </div>
                    <div class="form-floating m-3">
                        <input type="password" class="form-control" placeholder="Password" minlength="5" maxlength="128"
                            name="cpassword">
                        <div class="invalid-feedback">
                            Please write a correct password containing at least 5 symbols.
                        </div>
                        <label class="form-label">Repeat password</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="change_password"
                            class="btn btn-outline-dark btn-lg mb-3">Change</button>
                    </div>
                    <div class="ms-2">
                        <button type="submit" name="logout" class="btn btn-outline-dark btn-lg mb-3">Log out</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php }
?>



<?php
include "footer.php";
//var_dump($_POST);
if (isset($_POST['save_changes'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['cpassword'];
    $returnValue = $userContr->resetDetails($name, $surname, $email);
    if ($returnValue == "fields_not_full") {
        callAlert("Wrong detail change input! Try again.", "alert-danger");
    }
    if ($password != "" || $confirmPassword != "") {
        $returnValue = $userContr->resetPassword($email, $password, $confirmPassword);
        if ($returnValue == "passwords_no_match") {
            callAlert("Passwords do not match! Try again.", "alert-danger");
        } elseif ($returnValue == "fields_not_full") {
            callAlert("Wrong password input! Try again.", "alert-danger");
        }
    }
    //callAlert("Successfully changed the user details!", "alert-success");
    unset($_POST);
    header("Refresh:2");
}
if (isset($_POST['logout'])) {
    unset($_SESSION);
    header("Location: index.php");
}
if (isset($_POST['change_details'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $returnValue = $userContr->resetDetails($name, $surname, $currentEmail);
    header("Refresh:2");
    if ($returnValue == "fields_not_full") {
        callAlert("Wrong detail change input! Try again.", "alert-danger");
    } elseif ($returnValue == "success") {
        callAlert("Successfully changed the user details!", "alert-success");
    }
}
if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['cpassword'];
    $returnValue = $userContr->resetPassword($currentEmail, $password, $confirmPassword);
    if ($returnValue == "passwords_no_match") {
        callAlert("Passwords do not match! Try again.", "alert-danger");
    } elseif ($returnValue == "fields_not_full") {
        callAlert("Wrong password input! Try again.", "alert-danger");
    } else {
        callAlert("Password changed successfully!", "alert-success");
        //header("Refresh: 2");
    }
}
?>



<script>
    $(function () {

        $('.change_detail_js').on("click", function () {
            alert("Working change_detail_js");
        });

        $('button').on("click", function () {
            var email = $(this).attr('value');
            if ($(this).attr('name') === "delete") {
                $(this).children().show();
                $.ajax({
                    type: "post",
                    url: "main.ajax.php",
                    dataType: "html",
                    data: { delete: email },
                    success: function (message) {
                        $('#continue').append(message);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                });
            }
            else if ($(this).attr('name') === "change") {
                //$(this).children().show();
                console.log(email);
                $.ajax({
                    type: "post",
                    url: "main.ajax.php",
                    dataType: "html",
                    data: { details: email },
                    success: function (response) {
                        $('#continue').append(response);
                        $('#changeDetails').modal('show');
                        //$(this).children().hide();
                    }
                });
            }
            //console.log(buttonID);
        });
    });
</script>

</body>

</html>