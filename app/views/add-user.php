<?php
include_once "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';
// if user is not admin, can not see this page
if($_SESSION['isAdmin'] === 0) {
    header('location: /404');
    die();
}
// recalled data after error
$firstname = $_SESSION['preUserData']['firstname'] ?? null;
$lastname = $_SESSION['preUserData']['lastname'] ?? null;
$username = $_SESSION['preUserData']['username'] ?? null;
$email = $_SESSION['preUserData']['email'] ?? null;
//delete session data
unset($_SESSION['preUserData'])
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add User</h2>

            <?php if (isset($_SESSION['addUser'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?php
                        echo $_SESSION['addUser'];
                        unset($_SESSION['addUser']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="add-user-logic"
                  enctype="multipart/form-data"
                  method="POST">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword"  placeholder="Create Password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
                <select name="role">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <div style="display: inline-flex">
                    <button type="submit" name="submit" class="btn">Add User</button>
                    <small style="margin-left: 1rem">Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
                </div>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>