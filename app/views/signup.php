<?php
include_once "../app/partials/header.php";
// this will get back previously given areas after getting an error message
$firstname = $_SESSION['previouslyTypedData']['firstname'] ?? null;
$lastname = $_SESSION['previouslyTypedData']['lastname'] ?? null;
$username = $_SESSION['previouslyTypedData']['username'] ?? null;
$email = $_SESSION['previouslyTypedData']['email'] ?? null;
// unset the session
unset($_SESSION['previouslyTypedData']);

if(isset($_SESSION['userId'])) {
    header('location: index');
    die();
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign Up</h2>

        <?php if (isset($_SESSION['signup'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    echo $_SESSION['signup'];
                    unset($_SESSION['signup']);
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <form action="signup-logic"
              enctype="multipart/form-data"
              method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
            <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" placeholder="Create Password">
            <input type="password" name="confirmpassword" placeholder="Confirm Password">
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already have an account? <a href="login" style="color: deeppink">Sign In</a></small>
        </form>
    </div>
</section>

<?php
include_once "../app/partials/footer.php";
?>