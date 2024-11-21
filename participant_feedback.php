<?php 
    ob_start(); 
    //to display errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //database connection
    include("connection.php");

    include ('components/alerts.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {

        $title = $_POST['title'];
        $name = $_POST['name'];
        $emcee = $_POST['emcee'];
        $feedback = $_POST['feedback'];

        $insert_sql = "INSERT INTO `feedback` (`activity_title`, `participant_name`, `feedback`, `emcee`) 
        VALUES (?, ?, ?, ?)";
        $stmt_insert = $connForActivities->prepare($insert_sql);
        $stmt_insert->execute([$title, $name, $feedback, $emcee]);

        header('Location: participant_feedback.php');
        exit;
    }

    $activity_list = $connForActivities->query("SELECT * FROM `activities`")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PARTICIPANT FEEDBACK | CEMS</title>

    <!-- FONTAWESOME CSS-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- DASHBOARD CSS-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DATATABLE CDN -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("components/topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class=" text-center mb-4">
                        <h1 class=" mb-0 text-gray-800">PARTICIPANT FEEDBACK</h1>
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
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFeedback-<?php echo $activities['id']; ?>">
                                            Give Feedback
                                        </button>

                                    </div>
                                </div>
                            </div>

                            <!-- Feedback Modal for this activity -->
                            <div class="modal fade" id="addFeedback-<?php echo $activities['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addFeedbackLabel-<?php echo $activities['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog d-flex align-items-center" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFeedbackLabel-<?php echo $activities['id']; ?>">Give Feedback for <?php echo $activities['activity_title']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="activity_id" value="<?php echo $activities['id']; ?>">

                                                <div class="form-group">
                                                    <label for="title-<?php echo $activities['id']; ?>">Activity Title</label>
                                                    <input type="text" class="form-control" id="title-<?php echo $activities['id']; ?>" name="title" value="<?php echo ($activities['activity_title']); ?>" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Your Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="emcee-<?php echo $activities['id']; ?>">Emcee Name</label>
                                                    <input type="text" class="form-control" id="emcee-<?php echo $activities['id']; ?>" name="emcee" value="<?php echo ($activities['emcee']); ?>" readonly>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="feedback">Your Feedback</label>
                                                    <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="submit_feedback">Submit Feedback</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include("components/footer.php"); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap JS (includes jQuery and Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>
