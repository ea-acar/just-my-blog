<?php
include_once "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';


if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    function fetchPost () {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM posts WHERE id=$id";
        return sqlQueryBuilder($query);
    }
    function fetchCategories () {
        $queryFetchCategories = "SELECT * FROM categories";
        return sqlQueryBuilder($queryFetchCategories);
    }

    if(isset($_SESSION['userAdmin'])) {
        $post = fetchPost();
        $categories = fetchCategories();
    } elseif (isset($_SESSION['userId'])) {

        $query = "SELECT * FROM posts WHERE posts.id=$id";
        $postUser = sqlQueryBuilder($query);
        if ($postUser[0]['userid'] == $_SESSION['userId']) {
            $post = fetchPost();
            $categories = fetchCategories();
        } else {
            header('location: dashboard');
            die();
        }
    } else {
        header('location: dashboard');
    }
} else {
    header('location: index');
}
?>

    <section class="form__section">
        <div class="container form__section-container">

            <?php if (isset($_SESSION['editPostErrorMessage'])) : ?>
                <div class="alert__message error">
                    <p><?php
                        echo $_SESSION['editPostErrorMessage'];
                        unset($_SESSION['editPostErrorMessage']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <h2>Edit Post</h2>
            <form action="edit-post-logic" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?= $post[0]['id'] ?>">
                <input type="hidden" name="userid" value="<?= $post[0]['userid'] ?>">
                <input type="hidden" name="prevThumbnailName" value="<?= $post[0]['thumbnail'] ?>">
                <input type="text" name="title" value="<?= $post[0]['title'] ?>" placeholder="Title">
                <select name="category">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea rows="10" placeholder="Body" name="content"><?= $post[0]['content'] ?></textarea>
                <div class="form__control inline">
                    <input type="checkbox" name="isFeatured" id="isFeatured" value="1" checked>
                    <label for="is_featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Change Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Update Post</button>
                <small>Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>