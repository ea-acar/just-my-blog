<?php


include_once '../app/partials/header.php';
require_once '../app/logics/dashboard-logic.php';

// if user is not admin, can not see this page
if($_SESSION['isAdmin'] === 0) {
    header('location: index');
    die();
}
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>

            <?php if (isset($_SESSION['errorMessageCategory'])) : ?>
                <div class="alert__message danger">
                    <p>
                        <?php
                        echo $_SESSION['errorMessageCategory'];
                        unset($_SESSION['errorMessageCategory']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <form action="add-category-logic" method="post">
                <input type="text" name="title" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"></textarea>
                <button type="submit" name="submit" class="btn">Add Category</button>
                <small>Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>