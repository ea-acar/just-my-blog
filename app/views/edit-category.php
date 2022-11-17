<?php
include_once "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';

if(isset($_SESSION['userAdmin'])) {
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM categories WHERE id=$id";
        $result = sqlQueryBuilder($query);
        $category = $result;
        $_SESSION['editCategoryId'] = $id;
    } else {
        header('location: manage-categories');
        die();
    }
} else {
    header('location: index');
    die();
}
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Category</h2>
            <form action="edit-category-logic" method="post">
                <input type="text" name="category" value="<?= $category[0]['category'] ?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?= $category[0]['description'] ?></textarea>
                <button type="submit" name="submit" class="btn">Update Category</button>
                <small>Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>