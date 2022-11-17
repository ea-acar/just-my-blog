<?php
include '../app/partials/header.php';

if($_GET['id'] && $_GET['id'] > 0) {

    $postId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$postId";
    $post = sqlQueryBuilder($query);
} else {
    header('location: index');
    die();
}

?>

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post[0]['title'] ?></h2>
            <div class="post__author">
                <?php
                // fetch author from users table using author_id
                $authorId = $post[0]['userid'];
                $authorQuery = "SELECT * FROM users WHERE id=$authorId";
                $author = sqlQueryBuilder($authorQuery);
                ?>
                <div class="post__author-avatar">
                    <img src="images/<?= $author[0]['avatar'] ?>" alt="">
                </div>
                <div class="post__author-info-date">

                    <h6 style="color: var(--color-gray-900); transform: rotate(300deg)">Author</h6>
                    <h3 style="color: var(--color-primary-light)"> <?= $author[0]['firstname'] ?> <br> <?= $author[0]['lastname'] ?></h3>
                    <br>
                    <div class="post__author-inline">
                        <small style="font-size: 0.5rem; float: left; width: 100%">
                            <?= date("M d, Y - H:i", strtotime($post[0]['date'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="images/<?= $post[0]['thumbnail'] ?>" alt="">
            </div>
            <p>
                <?= $post[0]['content'] ?>
            </p>
        </div>
    </section>

<?php
include "../app/partials/footer.php";
?>