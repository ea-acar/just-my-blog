<?php
include_once "../app/partials/header.php";
if (!isset($_SESSION['userId']))
    header('location: login');

if (isset($_SESSION['userAdmin'])) {
    //query for posts
    $query = "SELECT posts.id, posts.userid, categories.category, posts.title FROM posts INNER JOIN categories ON posts.categoryid = categories.id";

} else {
    $userid = $_SESSION['userId'];
    $query = "SELECT posts.id, posts.userid, categories.category, posts.title FROM posts INNER JOIN categories ON posts.categoryid = categories.id WHERE userid=$userid";
}
$posts = sqlQueryBuilder($query);

?>

    <section class="dashboard">
        <div class="container dashboard__container">
            <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
            <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
            <aside>
                <ul>
                    <li>
                        <a href="add-post"><i class="uil uil-pen"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['userAdmin'])) : ?>
                        <li>
                            <a href="add-user"><i class="uil uil-user-plus"></i>
                                <h5>Add User</h5>
                            </a>
                        </li>
                        <li>
                            <a href="add-category"><i class="uil uil-edit"></i>
                                <h5>Add Category</h5>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="dashboard" class="active"><i class="uil uil-postcard"></i>
                            <h5>Manage Posts</h5>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['userAdmin'])) : ?>
                        <li>
                            <a href="manage-user"><i class="uil uil-users-alt"></i>
                                <h5>Manage User</h5>
                            </a>
                        </li>
                        <li>
                            <a href="manage-categories"><i class="uil uil-list-ul"></i>
                                <h5>Manage Categories</h5>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Posts</h2>
                <?php if (isset($_SESSION['editPostSucceed'])) : ?>
                    <div class="alert__message success">
                        <p><?php
                            echo $_SESSION['editPostSucceed'];
                            unset($_SESSION['editPostSucceed']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['postSucceed'])) : ?>
                    <div class="alert__message success">
                        <p><?php
                            echo $_SESSION['postSucceed'];
                            unset($_SESSION['postSucceed']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['deletePostSucceed'])) : ?>
                    <div class="alert__message success">
                        <p><?php
                            echo $_SESSION['deletePostSucceed'];
                            unset($_SESSION['deletePostSucceed']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
                <table>
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($posts) : ?>

                        <?php foreach ($posts as $post) : ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $post['category'] ?></td>
                                <td><a href="edit-post?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="delete-post-logic?id=<?= $post['id'] ?>"
                                       class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert__message error">
                            <p>No post has been found. Post something, eh?</p>
                        </div>
                    <?php endif; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>