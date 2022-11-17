<?php
include '../app/partials/header.php';

if($_GET['id'] > 0) {
$categoryId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM categories WHERE id=$categoryId";
$selectedCategory = sqlQueryBuilder($query);

$query = "SELECT * FROM categories";
$allCategories = sqlQueryBuilder($query);

$query = "SELECT posts.id, posts.userid, posts.categoryid, posts.thumbnail, posts.title, posts.content, users.avatar, users.firstname, users.lastname 
            FROM posts 
            JOIN users ON posts.userid = users.id
            WHERE posts.categoryid = $categoryId
            ORDER BY posts.date DESC";
$posts = sqlQueryBuilder($query);
} else {
    header('location: index');
    die();
}

?>


    <header class="category__title">
        <div>
            <h2><?= $selectedCategory[0]['category'] ?></h2>
            <h3>-- <?= $selectedCategory[0]['description'] ?></h3>
        </div>
    </header>

    <section class="posts">
        <div class="container posts__container">
            <?php if ($posts) : ?>
                <?php foreach ($posts as $post) : ?>
                    <article class="post">
                        <div class="post__thumbnail">
                            <a href="post?id=<?= $post['id']?>">
                                <img src="images/<?= $post['thumbnail'] ?>">
                            </a>
                        </div>

                        <div class="post__info">
                            <h3 class="post__title">
                                <a href="post?id=<?= $post['id']?>"><?= $post['title'] ?></a>
                            </h3>
                            <p class="post__body">
                                <?= $post['content'] ?>
                            </p>
                            <div class="post__author">

                                <div class="post__author-avatar">
                                    <img src="images/<?= $post['avatar'] ?>" alt="">
                                </div>
                                <div class="post__author-info-date">

                                    <h6 style="color: #F9F871; transform: rotate(300deg)">Author</h6>
                                    <h3 style="color: var(--color-gray-900)"> <?= $post['firstname'] ?>
                                        <br> <?= $post['lastname'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>

                <div class="alert__message error">
                    <p>
                        <?= "There is nothing to see." ?>
                    </p>
                </div>

            <?php endif; ?>
        </div>
    </section>

    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php foreach ($allCategories as $category) : ?>
                <a href="category-posts?id=<?= $category['id'] ?>"
                   class="category__button"><?= $category['category'] ?></a>
            <?php endforeach; ?>
        </div>
    </section>

<?php
include '../app/partials/footer.php'
?>