<?php

require_once "usersController.php";

class UsersView {

    public function viewUsers($emails){
        $userContr = new UsersController();
        foreach ($emails as $user) {
            $currentUser = $userContr->seeUser($user['EMAIL']);
            ?>

            <div class="col">
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $user['EMAIL']; ?></h5>
                        <p class="card-text">User ID: <strong><?php echo $currentUser['ID_USER']; ?></strong><br> Name: <strong><?php echo $currentUser['FIRST_NAME']; ?></strong><br>Surname: <strong><?php echo $currentUser['LAST_NAME']; ?></strong></p>
                        <div class="text-center">
                            <button name="change" value="<?php echo $user['EMAIL'];?>" class="btn btn-primary change_detail_js">Change details
                                <div class="spinner-border spinner-border-sm text-white" style="display: none"></div>
                            </button>
                            <button name="delete" value="<?php echo $user['EMAIL'];?>" class="btn btn-danger">Delete
                                <div class="spinner-border spinner-border-sm text-white" style="display: none"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
    }

    public function showDetailsModal($email){
        $userContr = new UsersController();
        $user = $userContr->seeUser($email);
        ?>
        <div class="modal fade" id="changeDetails" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change user details</h5>
                        <button type="button" name="close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <form action="main.php" method="post" class="needs-validation" novalidate>
                                <div class="text-center">
                                    <h4><?php echo $email . " management";?></h4>
                                </div>
                                <div class="form-floating m-3">
                                    <input type="hidden" value="<?php echo $email; ?>" name="email">
                                    <input type="text" class="form-control" placeholder="Name" required minlength="2" maxlength="30" value="<?php echo $user['FIRST_NAME']; ?>" name="name">
                                    <div class="invalid-feedback">
                                        Please write a name (2-30 letters).
                                    </div>
                                    <label class="form-label">Name</label>
                                </div>
                                <div class="form-floating m-3">
                                    <input type="text" class="form-control" placeholder="Surname" required minlength="2" maxlength="30" value="<?php echo $user['LAST_NAME']; ?>" name="surname">
                                    <div class="invalid-feedback">
                                        Please write a surname (2-30 letters).
                                    </div>
                                    <label class="form-label">Surname</label>
                                </div>
                                <div class="form-floating m-3">
                                    <input type="password" class="form-control" placeholder="Password" minlength="5" maxlength="128" name="password">
                                    <div class="invalid-feedback">
                                        Please write a correct password containing at least 5 symbols.
                                    </div>
                                    <label class="form-label">Password</label>
                                </div>
                                <div class="form-floating m-3">
                                    <input type="password" class="form-control" placeholder="Password" minlength="5" maxlength="128" name="cpassword">
                                    <div class="invalid-feedback">
                                        Please write a correct password containing at least 5 symbols.
                                    </div>
                                    <label class="form-label">Repeat password</label>
                                </div>
                                <div class="text-end mt-2">
                                    <button name="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button name="save_changes" type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>