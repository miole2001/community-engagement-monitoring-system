<?php 
    include("../components/user-header.php");
        
    $feedback_list = $connForActivities->query("SELECT * FROM `feedback`")->fetchAll(PDO::FETCH_ASSOC);

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
                                <th>Title</th>
                                <th>Particpants</th>
                                <th>Emcee</th>
                                <th>Feedback</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Particpants</th>
                                <th>Emcee</th>
                                <th>Feedback</th>
                                <th>Timestamp</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($feedback_list as $feedback):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo ($feedback['activity_title']); ?></td>
                                    <td><?php echo ($feedback['participant_name']); ?></td>
                                    <td><?php echo ($feedback['emcee']); ?></td>
                                    <td><?php echo ($feedback['feedback']); ?></td>
                                    <td><?php echo ($feedback['timestamp']); ?></td>
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