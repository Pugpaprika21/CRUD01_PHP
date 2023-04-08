<?php require __DIR__ . '../../src/include/include.php'; ?>

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

        .btn-custom-json {
            padding: 6px 8px;
            font-size: 10px;
            color: #303030;
            background-color: #F3D607;
            border-color: #F3D607;
        }

        .btn-custom-json:hover {
            background-color: #F3E791;
            border-color: #F3E791;
        }
    </style>
</head>

<body>

    <!-- nav -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                CRUD
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
                            <form id="form-submit-create-users" action="" method="post">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="input-group mb-2 mt-2">
                                            <input type="text" class="form-control" id="user_name" name="user_name" value="" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="input-group mb-2 mt-2">
                                            <input type="text" class="form-control" id="user_pass" name="user_pass" value="" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <button class="btn btn-primary w-100" type="submit">Save</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">

                    <!--  -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-custom-json mb-2" id="load-json" href="<?= url_where('../process/get_file_json.php', ['action' => 'load_json']) ?>" role="button">json</a>
                    </div>

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
                            <tbody id="show-users">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?= JS_SWL ?>"></script>
    <script src="<?= JS_AXIOS ?>"></script>

</body>

</html>

<script>
    document.querySelector('#form-submit-create-users').addEventListener('submit', (e) => {
        e.preventDefault();

        const user_name = document.getElementById("user_name").value;
        const user_pass = document.getElementById("user_pass").value;

        if (user_name == '') return;
        if (user_pass == '') return;

        axios.post("<?= url_where('../process/save_user.php', array('action' => 'insert')) ?>", {
            user_name: user_name,
            user_pass: user_pass,
            action: "insert"
        }).then(res => {
            if (res.status == 200) {
                Swal.fire({
                    icon: 'success',
                    text: 'Data addition successful.',
                }).then(res => {
                    document.getElementById("user_name").value = "";
                    document.getElementById("user_pass").value = "";
                    fetchUsers();
                });
                return;
            }

            Swal.fire({
                icon: 'error',
                text: 'cannot add data.'
            });
            return;

        }).catch(err => {
            console.error(err);
        })
    });

    function fetchUsers() {
        axios.get("<?= url_where('../process/show_users.php', array('action' => 'get_users')) ?>").then(res => {
            let html = "";
            let row = 0;
            //console.log(res);
            if (res.data.length > 0) {
                res.data.forEach(data => {
                    html += `
                        <tr>
                            <td>${row + 1}</td>
                            <td>${data.user_name}</td>
                            <td>${data.user_pass}</td>
                            <td>${data.create_date_at}</td>
                            <td>
                                <button type="button" class="btn btn-custom-edit" id="edit_${data.user_id}" onclick="editUserDataId(${data.user_id})" data-bs-toggle="modal" data-bs-target="#modal-edit">
                                    Edit
                                </button>
                                <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                                                <button type="button" class="btn-close" id="btn-close-edit-${data.user_id}" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-edit-user" action="" method="post">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="input-group mb-2 mt-2">
                                                                <input type="text" class="form-control" id="e_user_name" name="user_name" value="" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="input-group mb-2 mt-2">
                                                                <input type="text" class="form-control" id="e_user_pass" name="user_pass" value="" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <button class="btn btn-primary w-100" type="submit">Save</button>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;
                                <a class="btn btn-custom-delete" id="delete_${data.user_id}" onclick="deleteUserId(${data.user_id})" role="button">Delete</a>
                            </td>
                        </tr>
                    `;
                    document.getElementById("show-users").innerHTML = html;
                    row++;
                });
            }
        }).catch(err => {
            console.error(err);
        })
    }

    async function editUserDataId(user_id) {

        const edit_url = "<?= url_where('../process/edit_user.php', array('action' => 'edit_user_data', 'user_id' => '_user_id')) ?>".replace("_user_id", user_id);
        const resp = await axios.get(edit_url);

        if (resp.data.user_id != "") {

            const user_id = resp.data.user_id
            const user_name = document.getElementById("e_user_name").value = resp.data.user_name;
            const user_pass = document.getElementById("e_user_pass").value = resp.data.user_pass;

            document.getElementById("form-edit-user").addEventListener('submit', (e) => {
                e.preventDefault();

                const resp_edit = axios.put("<?= url_where('../process/edit_user_data.php', array('action' => 'edit_user_data')) ?>", {
                    user_id: user_id,
                    user_name: document.getElementById("e_user_name").value,
                    user_pass: document.getElementById("e_user_pass").value
                });

                if (resp.status == 200) {

                    document.getElementById(`btn-close-edit-${user_id}`).click();

                    setInterval(() => {
                        fetchUsers();
                    }, 1000);
                }
            });
        }
    }

    async function deleteUserId(user_id) {

        const delete_url = "<?= url_where('../process/delete_user.php', array('action' => 'delete_user', 'user_id' => '_user_id')) ?>".replace("_user_id", user_id);
        const resp = await axios.get(delete_url);

        if (resp.status == 200) {
            Swal.fire({
                icon: 'success',
                text: 'Data is delete.',
            }).then(res => {
                fetchUsers();
                return;
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        fetchUsers();
    });
</script>