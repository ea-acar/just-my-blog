<?php
include "../app/partials/header.php";

$usernameOrMail = $_SESSION['previouslyTypedLoginData']['usernameOrMail'] ?? null;
$password = $_SESSION['previouslyTypedLoginData']['password'] ?? null;
// unset the session
unset($_SESSION['previouslyTypedLoginData'])
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign In</h2>

        <?php if (isset($_SESSION['signupSucceed'])) : ?>
            <div class="alert__message success">
                <p>
                    <?php
                    echo $_SESSION['signupSucceed'];
                    unset($_SESSION['signupSucceed']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['login'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <form action="login-logic" method="POST">
            <input type="text" name="usernameOrMail" value="<?= $usernameOrMail ?>"  placeholder="Username or Email">
            <input type="password" name="password" value="<?= $password ?>"  placeholder="Password">
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't you have an account? <a href="signup" style="color: deeppink">Sign Up</a></small>
        </form>
    </div>
</section>

<?php
include_once "../app/partials/footer.php";
?>