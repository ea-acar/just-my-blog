<?php
include_once "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';

if($_SESSION['isAdmin'] === 0) {
    header('location: index');
    die();
}

if(isset($_GET['id']) && $_GET['id'] > 0) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = sqlQueryBuilder($query);
    $user = $result;
    $_SESSION['editUserId'] = $id;
} else {
    header('location: manage-user');
    die();
}
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit User</h2>
            <form action="edit-user-logic" method="post">
                <input type="text" name="firstname" value="<?= $user[0]['firstname'] ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $user[0]['lastname'] ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $user[0]['username'] ?>" placeholder="Last Name">
                <select name="role">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <button type="submit" name="submit" class="btn">Update User</button>
                <small>Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>