<?php
include "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';

if($_SESSION['isAdmin'] === 0) {
    header('location: /404');
    die();
}

$query = "SELECT * FROM categories";
$categories = sqlQueryBuilder($query);
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
                        <a href="dashboard"><i class="uil uil-postcard"></i>
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
                            <a href="manage-categories" class="active"><i class="uil uil-list-ul"></i>
                                <h5>Manage Categories</h5>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Categories</h2>
                <?php if (isset($_SESSION['categoryDeleteForbidden'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?php
                            echo $_SESSION['categoryDeleteForbidden'];
                            unset($_SESSION['categoryDeleteForbidden']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['categoryDeleteSucceed'])) : ?>
                    <div class="alert__message success">
                        <p>
                            <?php
                            echo $_SESSION['categoryDeleteSucceed'];
                            unset($_SESSION['categoryDeleteSucceed']);
                            ?>
                        </p>
                    </div>
                <?php elseif (isset($_SESSION['deleteCategoryErrorMessage'])) : ?>

                    <div class="alert__message error">
                        <p>
                            <?php
                            echo $_SESSION['categoryDeleteSucceed'];
                            unset($_SESSION['categoryDeleteSucceed']);
                            ?>
                        </p>
                    </div>

                <?php endif; ?>

                <?php if (isset($_SESSION['editCategoryMessage'])) : ?>
                    <div class="alert__message error">
                        <p>
                            <?php
                            echo $_SESSION['editCategoryMessage'];
                            unset($_SESSION['editCategoryMessage']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['editCategorySucceed'])) : ?>
                    <div class="alert__message success">
                        <p>
                            <?php
                            echo $_SESSION['editCategorySucceed'];
                            unset($_SESSION['editCategorySucceed']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['addCategorySucceed'])) : ?>
                    <div class="alert__message success">
                        <p>
                            <?php
                            echo $_SESSION['addCategorySucceed'];
                            unset($_SESSION['addCategorySucceed']);
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
                <table>
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?php echo $category['category']?></td>
                            <td><a href="edit-category?id=<?=$category['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="delete-category-logic?id=<?=$category['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>

<?php
include_once "../app/partials/footer.php";
?>