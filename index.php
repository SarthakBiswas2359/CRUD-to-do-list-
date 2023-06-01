<?php

// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES ('1','sarthak','buy books',current_timestamp());
//Establishing connection
$insert = false;
$update = false;
$delete = false;
$servername = "localhost:3307";
$username = "username";
$password = "password";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
echo " connection failed <br>";
}
if (isset($_GET['delete'])) {
$sno = $_GET['delete'];
$delete = true;
$sql = "DELETE FROM `notes` WHERE `sno` = $sno";
$result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['snoEdit'])) {
//Update the record
$sno = $_POST["snoEdit"];
$title = $_POST["title"];
$description = $_POST["description"];

$sql =
"UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
$result = mysqli_query($conn, $sql);
if ($result) {
$update = true;
} else {
echo "We could not update the record";
}

} else {
$title = $_POST["title"];

$description = $_POST["description"];

$sql =
"INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp());";
$result = mysqli_query($conn, $sql);

if ($result) {
// echo (" the data was recorded successfully<br>");
$insert = true;
} else {
echo ("Data couldn't be recorded due to an error");
}
}
}
?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHP CRUD</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
            crossorigin="anonymous">
        <link rel="stylesheet"
            href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    </head>

    <body>
        <!-- edit modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

        <!-- edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Note</h1>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"
                            style="border: none; font-size: 20px; background-color: transparent;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/crud/index.php" method="post">
                        <div class="modal-body">
                            <!-- //////////////////////////////////////////////////////////////////////////// -->

                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Note
                                    Title</label>
                                <input type="text" class="form-control"
                                    id="titleEdit" name="title"
                                    aria-describedby="emailHelp">

                            </div>

                            <div class="form-floating">
                                <textarea class="form-control"
                                    id="descriptionEdit" name="description"
                                    rows="4"></textarea>
                                <label for="desc">Description</label>
                            </div>
                            

                            <!-- /////////////////////////////////////////////////////////////////////////////////////// -->
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Taskify</a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse"
                    id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search"
                            placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <?php
        if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show'
            role='alert'>
            <strong>Success!</strong> Your note has been successfully recorded
            <button type='button' class='btn-close' data-bs-dismiss='alert'
                aria-label='Close'></button>
        </div>";
        }
        ?>
        <?php
        if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show'
            role='alert'>
            <strong>Success!</strong> Your note has been deleted successfully
            <button type='button' class='btn-close' data-bs-dismiss='alert'
                aria-label='Close'></button>
        </div>";
        }
        ?>
        <?php
        if ($update) {
        echo "<div class='alert alert-primary alert-dismissible fade show'
            role='alert'>
            <strong>Success!</strong> Your note has been updated successfully
            <button type='button' class='btn-close' data-bs-dismiss='alert'
                aria-label='Close'></button>
        </div>";
        }
        ?>
        <div class="container my-5">
            <h2>Add a Note</h2>
            <form action="/crud/index.php" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Note
                        Title</label>
                    <input type="text" class="form-control" id="title"
                        name="title" aria-describedby="emailHelp">

                </div>

                <div class="form-floating">
                    <textarea class="form-control" id="description"
                        name="description" rows="4"></textarea>
                    <label for="desc">Description</label>
                </div>
                <button style=" margin: 20px;" type="submit"
                    class="btn btn-primary">Add Note</button>
            </form>
        </div>

        <div class="container my-4">

            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.no</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo " <tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td> <button class='edit btn btn-sm btn-primary'
                                id=" . $row['sno'] . ">Edit</button>
                            <button class='delete btn btn-sm btn-primary' id=d"
                                . $row['sno'] . ">Delete</button></td>
                    </tr>";

                    }

                    ?>

                </tbody>
            </table>
        </div>
        <hr>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script>
        $(document).ready(function () {
            $('#myTable').DataTable();

        });
    </script>
        <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit",);
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                descriptionEdit.value = description;
                titleEdit.value = title;
                snoEdit.value = e.target.id
                console.log(e.target.id)
                $('#editModal').modal('toggle');
            })

        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit",);
                sno = e.target.id.substr(1,);
                window.location = `/crud/index.php?delete=${sno}`;
                //TODO: create a from and use post request to sudmit a form 
                if (confirm("Are you sure?")) {
                    console.log("yes");
                }
                else {
                    console.log("no");
                }

            })
        })
    </script>
    </body>

</html>
