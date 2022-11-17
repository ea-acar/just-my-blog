<?php
include_once '../app/partials/header.php';
require_once '../app/logics/dashboard-logic.php';

// fetch categories
$query = "SELECT * FROM categories";
$categories = sqlQueryBuilder($query);
//prevData
$title = $_SESSION['prevTypedPostData']['title'] ?? null;
$content = $_SESSION['prevTypedPostData']['content'] ?? null;
unset($_SESSION['prevTypedPostData']);
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Post</h2>

            <?php if (isset($_SESSION['addPostErrorMessage'])) : ?>

                <div class="alert__message error">
                    <p><?php
                        echo $_SESSION['addPostErrorMessage'];
                        unset($_SESSION['addPostErrorMessage']);
                        ?>
                    </p>
                </div>

            <?php endif; ?>


            <form action="add-post-logic" enctype="multipart/form-data" method="post">
                <input type="text" name="title" placeholder="Title">
                <select name="category">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea rows="10" name="content" placeholder="Body"></textarea>

                <?php if (isset($_SESSION['userAdmin'])) : ?>
                    <div class="form__control inline">
                        <input type="checkbox" name="isFeatured" value="1" id="is_featured" checked>
                        <label for="is_featured">Featured</label>
                    </div>
                <?php endif; ?>

                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
                <small>Go back to <a href="dashboard" style="color: var(--color-gray-900)">dashboard</a></small>
            </form>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>