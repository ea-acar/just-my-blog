<?php
include "../app/partials/header.php";
require_once '../app/logics/dashboard-logic.php';

if($_SESSION['isAdmin'] === 0) {
    header('location: index');
    die();
}

// fetch all users except current user
$currentAdminId = $_SESSION['userId'];
$query = "SELECT * FROM users WHERE NOT id=$currentAdminId";
$users = sqlQueryBuilder($query);
?>

    <section class="dashboard">

        <?php if (isset($_SESSION['deleteUserMessage'])) : ?>
            <div class="alert__message success">
                <p>
                    <?php
                    echo $_SESSION['deleteUserMessage'];
                    unset($_SESSION['deleteUserMessage']);
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['editUserSucceed'])) : ?>
            <div class="alert__message success">
                <p>
                    <?php
                    echo $_SESSION['editUserSucceed'];
                    unset($_SESSION['editUserSucceed']);
                    ?>
                </p>
            </div>
        <?php elseif (isset($_SESSION['editUserMessage'])) : ?>
            <div class="alert__message success">
                <p>
                    <?php
                    echo $_SESSION['editUserMessage'];
                    unset($_SESSION['editUserMessage']);
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['addUserSucceed'])) : ?>
            <div class="alert__message success container">
                <p>
                    <?php
                    echo $_SESSION['addUserSucceed'];
                    unset($_SESSION['addUserSucceed']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
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
                    <a href="dashboard"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                    <?php if (isset($_SESSION['userAdmin'])) : ?>
                        <li>
                            <a href="manage-user" class="active"><i class="uil uil-users-alt"></i>
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
                <h2>Manage Users</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo $user['firstname'] . " " . $user['lastname']?></td>
                            <td><?php echo $user['username']?></td>
                            <td><a href="edit-user?id=<?=$user['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="delete-user-logic?id=<?=$user['id']?>" class="btn sm danger">Delete</a></td>
                            <td><?php echo $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>

<?php
include "../app/partials/footer.php";
?>