<?php

require __DIR__ . '../../src/include/include.php';

$users = db_excQuery("SELECT user_id, user_name, user_pass, user_status, create_date_at, create_time_at FROM user_tb ORDER BY user_id DESC");
$users_json = json_encode($users);

$user_id = isset($_SESSION['user_edit_data']['user_data']['user_id']) ? $_SESSION['user_edit_data']['user_data']['user_id'] : "";
$username = isset($_SESSION['user_edit_data']['user_data']['user_name']) ? $_SESSION['user_edit_data']['user_data']['user_name'] : "";
$userpass = isset($_SESSION['user_edit_data']['user_data']['user_pass']) ? $_SESSION['user_edit_data']['user_data']['user_pass'] : "";
$status_data = isset($_SESSION['user_edit_data']['status_data']) ? $_SESSION['user_edit_data']['status_data'] : "";

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD01</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- stlye -->
    <style>
        /* หรือคุณสามารถกำหนดสีเองได้ */
        .btn-custom-edit {
            padding: 6px 8px;
            font-size: 10px;
            color: #FFFFFF;
            background-color: #2E44B5;
            border-color: #2E44B5;
        }

        .btn-custom-edit:hover {
            background-color: #586BCD;
            border-color: #586BCD;
        }

        .btn-custom-delete {
            padding: 6px 8px;
            font-size: 10px;
            color: #FFFFFF;
            background-color: #E84119;
            border-color: #E84119;
        }

        .btn-custom-delete:hover {
            background-color: #CA5F44;
            border-color: #CA5F44;
        }
    </style>
</head>

<body>

    <!-- nav -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Bootstrap
            </a>
        </div>
    </nav>

    <div class="container" id="app-crud01">
        <!-- grid -->
        <div class="show-users mt-4">
            <div class="row g-4"> <!-- gx-4 gy-4 -->
                <div class="col-md-4 col-sm-4">
                    <!-- add-users -->
                    <div class="add-users">
                        <div class="card">
                            <div class="card-header">
                                create user
                            </div>
                            <form action="<?= ($status_data == 'Y') ? url_where("../process/edit_user.php", ['user_id' => $user_id, 'status_edit' => 'Y']) : url_where('../process/save_user.php') ?>" method="post">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="input-group mb-2 mt-2">
                                            <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $username ?>" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="input-group mb-2 mt-2">
                                            <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                            <input type="text" class="form-control" id="user_pass" name="user_pass" value="<?= $userpass ?>" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <button class="btn btn-primary w-100" id="btn_add" name="btn_add" value="create_user" type="submit">Save</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <!-- table-users -->
                    <div class="table-responsive table-users">
                        <table class="table align-middle table-bordered text-center">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>username</td>
                                    <td>password</td>
                                    <td>create_at</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($users as $k => $row) : ?>

                                    <?php if (count($users) > 0) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $row['user_name'] ?></td>
                                            <td><?= $row['user_pass'] ?></td>
                                            <td><?= dt_th($row['create_date_at'] ." ". $row['create_time_at']) ?></td>
                                            <td>
                                                <a class="btn btn-custom-edit" id="edit_<?= $row['user_id'] ?>" href="<?= url_where('../process/edit_user.php', ['user_id' => $row['user_id']]) ?>" role="button">Edit</a>
                                                &nbsp;
                                                <a class="btn btn-custom-delete" id="delete_<?= $row['user_id'] ?>" href="<?= url_where('../process/delete_user.php', ['user_id' => $row['user_id']]) ?>" role="button">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?= JS_VUE ?>"></script>
    <script src="<?= JS_SWL ?>"></script>
    <script src="<?= JS_AXIOS ?>"></script>

</body>

</html>

<script>
    const {
        createApp
    } = Vue

    createApp({
        data() {
            return {

            }
        },
        mounted() {

        },
    }).mount('#app-crud01')
</script>