<?php 
    ob_start(); 
    include("../components/user-header.php"); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_activity'])) {
        $emcee = $_POST['emcee'];
        $title = $_POST['title'];
        $date = $_POST['date'];
        $location = $_POST['location'];

        $insert_sql = "INSERT INTO `activities` (`emcee`, `activity_title`, `activity_location`, `date`, `status`) 
        VALUES (?, ?, ?, ?, 'ongoing')";
        $stmt_insert = $connForActivities->prepare($insert_sql);
        $stmt_insert->execute([$emcee, $title, $location, $date]);

        header('Location: activities.php');
        exit;

    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_activity'])) {
        
        $title = $_POST['title'];
        $date = $_POST['date'];
        $location = $_POST['location'];
        $status = $_POST['status'];
        $activity_id = $_POST['activity_id'];

        $update_sql = "UPDATE `activities` SET `activity_title` = ?, `activity_location` = ?, `date` = ?, `status` = ? WHERE `id` = ?";
        $stmt_update = $connForActivities->prepare($update_sql);
        $stmt_update->execute([$title, $location, $date, $status, $activity_id]);

        // Redirect to the activity page after update
        header('Location: activities.php');
        exit;
    }

    // Handle deletion of activities
    if (isset($_GET['delete_activity'])) {
        $activity_id = $_GET['delete_activity'];

        // Prepare SQL query to delete the activity
        $delete_sql = "DELETE FROM `activities` WHERE `id` = ?";
        $stmt_delete = $connForActivities->prepare($delete_sql);
        $stmt_delete->execute([$activity_id]);

        // Redirect to the activity page after deletion
        header('Location: activities.php');
        exit;
    }

    $emcee_display = $connForAccounts->query("SELECT * FROM `user_accounts`")->fetchAll(PDO::FETCH_ASSOC);

    $activity_list = $connForActivities->query("SELECT * FROM `activities`")->fetchAll(PDO::FETCH_ASSOC);


?>


<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addActivity">
                Add New Activity
            </button>
        </div>

        <div class="row">
            <?php foreach ($activity_list as $activities): ?>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-uppercase text-center"><?php echo($activities['activity_title']); ?></h2>
                            <p class="card-text">Emcee: <?php echo($activities['emcee']); ?></p>
                            <p class="card-text">Location: <?php echo($activities['activity_location']); ?></p>
                            <p class="card-text">Date: <?php echo date("M j, Y", strtotime($activities['date'])); ?></p>
                            <p class="card-text">Status: <?php echo($activities['status']); ?></p>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editActivity">
                                Edit
                            </button>
                            <!-- Delete activity Button -->
                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo($activities['id']); ?>">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- /.container-fluid -->


    <!-- add conference Modal -->
    <div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="addActivityTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addActivityTitle">Add New Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="emcee">Emcee Name</label>
                            <input type="text" class="form-control" id="emcee" name="emcee" value="<?php echo ($emcee_display[0]['name']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="title">Activity Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="location">Activity Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>

                        <div class="form-group">
                            <label for="date">Activity Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_activity">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit activity Modal -->
    <div class="modal fade" id="editActivity" tabindex="-1" role="dialog" aria-labelledby="editActivityLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editActivityLabel">Edit Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="activity_id" value="<?php echo ($activities['id']); ?>">

                        <div class="form-group">
                            <label for="emcee">Emcee Name</label>
                            <input type="text" class="form-control" id="emcee" name="emcee" value="<?php echo ($activities['emcee']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="title">Activity Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo ($activities['activity_title']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="location">Activity Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo ($activities['activity_location']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="date">Activity Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo ($activities['date']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="ongoing" <?php echo ($activities['status'] === 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                                <option value="completed" <?php echo ($activities['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo ($activities['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit_activity">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const activityId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "activities.php?delete_activity=" + activityId;
                }
            });
        });
    });
</script>

</body>

</html>