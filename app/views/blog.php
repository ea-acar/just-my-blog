<?php
include '../app/partials/header.php';

$queryFeaturedPost = "SELECT * FROM posts WHERE is_featured=1";
$featured = sqlQueryBuilder($queryFeaturedPost);

$query = "SELECT * FROM categories";
$categories = sqlQueryBuilder($query);

?>

<?php if ($featured) : ?>
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail__featured">
                <a href="post?id=<?= $featured[0]['id'] ?>">
                    <img src="images/<?= $featured[0]['thumbnail'] ?>" alt="">
                </>
            </div>
            <div class="post__info">
                <?php
                // fetch category from categories table using category_id of post
                $categoryId = $featured[0]['categoryid'];
                $categoryQuery = "SELECT * FROM categories WHERE id=$categoryId";
                $category = sqlQueryBuilder($categoryQuery);
                ?>
                <a href="category-posts?id=<?= $featured[0]['categoryid'] ?>"
                   class="category__button"><?= $category[0]['category'] ?></a>
                <h2 class="post__title"><a href="post?id=<?= $featured[0]['id'] ?>"><?= $featured[0]['title'] ?></a></h2>
                <p class="post__body">
                    <?= substr($featured[0]['content'], 0, 300) ?>
                </p>
                <div class="post__author">
                    <?php
                    // fetch author from users table using author_id
                    $authorId = $featured[0]['userid'];
                    $authorQuery = "SELECT * FROM users WHERE id=$authorId";
                    $author = sqlQueryBuilder($authorQuery);
                    ?>
                    <div class="post__author-avatar">
                        <img src="images/<?= $author[0]['avatar'] ?>" alt="">
                    </div>
                    <div class="post__author-info-date">

                        <h6 style="color: #F9F871; transform: rotate(300deg)">Author</h6>
                        <h3 style="color: var(--color-gray-900)"> <?= $author[0]['firstname'] ?> <br> <?= $author[0]['lastname'] ?></h3>
                        <br>
                        <div class="post__author-inline">
                            <small style="font-size: 0.5rem; float: left; width: 100%">
                                <?= date("M d, Y - H:i", strtotime($featured[0]['date'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>


    <section class="posts">
        <div class="container posts__container">
            <?php
            $query = "SELECT posts.id, posts.date, posts.title, posts.categoryid, posts.content, posts.thumbnail, categories.category, posts.userid, users.avatar, users.firstname, users.lastname, posts.title 
                    FROM posts 
                    INNER JOIN users ON posts.userid = users.id 
                    INNER JOIN categories ON posts.categoryid = categories.id
                    ORDER BY posts.date DESC";
            $posts = sqlQueryBuilder($query);

            ?>

            <?php foreach ($posts as $post) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <a href="post?id=<?=$post['id']?>">
                            <img  src="images/<?= $post['thumbnail'] ?>" alt="">
                        </a>
                    </div>
                    <div class="post__info">
                        <a href="category-posts?id=<?= $post['categoryid'] ?>" class="category__button"><?= $post['category'] ?></a>
                        <h3 class="post__title">
                            <a href="post?id=<?=$post['id']?>"><?= $post['title'] ?></a>
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
                                <h3 style="color: var(--color-gray-900)"> <?= $post['firstname'] ?> <br> <?= $post['lastname'] ?></h3>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>


    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php foreach ($categories as $category) : ?>
                <a href="category-posts?id=<?= $category['id'] ?>" class="category__button"><?= $category['category'] ?></a>
            <?php endforeach; ?>
        </div>
    </section>

<?php
include '../app/partials/footer.php'
?>