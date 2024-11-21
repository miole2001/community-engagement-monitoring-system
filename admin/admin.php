<?php 
    include("../components/admin-header.php"); 

    $emcee_accounts = $connForAccounts->query("SELECT * FROM `user_accounts`")->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT COUNT(*) AS emcee_count FROM `user_accounts`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $emcee_count = $run_query->fetch(PDO::FETCH_ASSOC)['emcee_count'];

    $query = "SELECT COUNT(*) AS activities_count FROM `activities`";
    $run_query = $connForActivities->prepare($query);
    $run_query->execute();
    $activities_count = $run_query->fetch(PDO::FETCH_ASSOC)['activities_count'];

    $query = "SELECT COUNT(*) AS feedback_count FROM `feedback`";
    $run_query = $connForActivities->prepare($query);
    $run_query->execute();
    $feedback_count = $run_query->fetch(PDO::FETCH_ASSOC)['feedback_count'];

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
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Emcee Accounts
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $emcee_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i> <!-- New icon for Emcee Accounts -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Engagement Activities
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $activities_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i> <!-- New icon for Engagement Activities -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Feedback
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $feedback_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment-dots fa-2x text-gray-300"></i> <!-- New icon for Feedback -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Child Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Child Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($emcee_accounts as $emcee):
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><img src="../image/profile/<?php echo ($emcee['image']); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                    <td><?php echo ($emcee['name']); ?></td>
                                    <td><?php echo ($emcee['email']); ?></td>
                                    <td><?php echo ($emcee['password']); ?></td>
                                    <td><?php echo ($emcee['date_registered']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

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

</body>

</html>