<?php
session_start();
require_once("../controller/authCheck.php");
require_once("../model/applicationModel.php");

checkLoggedIn();
checkUserType("freelancer", "login.php");

$freelancer_id = $_SESSION['user_id'];
$accepted_applications = getFreelancerAcceptedApplications($freelancer_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Accepted Jobs - FreeMarket</title>
    <link rel="stylesheet" href="../asset/css/main-theme.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/jobView.css">
</head>
<body>
    <?php 
    include_once("../view/components/navbar.php");
    renderNavbar('dashboard');
    ?>

    <main>
        <section>
            <fieldset>
                <legend><h2>My Accepted Jobs</h2></legend>
                
                <?php if (empty($accepted_applications)): ?>
                    <p>No accepted jobs found. <a href="freelancerDashboard.php">Browse available jobs</a></p>
                <?php else: ?>
                    <?php foreach ($accepted_applications as $app): ?>
                        <div class="job-card">
                            <h3><?php echo htmlspecialchars($app['title']); ?></h3>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($app['description']); ?></p>
                            <p><strong>Payment:</strong> $<?php echo number_format($app['payment'], 2); ?></p>
                            <p><strong>Type:</strong> <?php echo ucfirst($app['job_type']); ?></p>
                            <p><strong>Status:</strong> 
                                <span class="status-<?php echo $app['status'] === 'completed' ? 'completed' : ($app['status'] === 'work_submitted' ? 'work-submitted' : 'accepted'); ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $app['status'])); ?>
                                </span>
                            </p>
                            
                            <?php if ($app['status'] === 'accepted'): ?>
                                <div class="status-card-ready">
                                    <p><strong>Ready to submit work?</strong></p>
                                    <a href="submitWork.php?application_id=<?php echo $app['application_id']; ?>" 
                                       class="btn-submit-work">
                                       Submit Work
                                    </a>
                                </div>
                            <?php elseif ($app['status'] === 'work_submitted'): ?>
                                <div class="status-card-submitted">
                                    <p><strong>Work Submitted:</strong> <?php echo htmlspecialchars($app['work_description']); ?></p>
                                    <?php if ($app['work_file']): ?>
                                        <p><strong>File:</strong> <?php echo htmlspecialchars($app['work_file']); ?></p>
                                    <?php endif; ?>
                                    <p><strong>Submitted on:</strong> <?php echo $app['work_submitted_date']; ?></p>
                                    <p class="status-text-pending"><em>Waiting for client approval...</em></p>
                                </div>
                            <?php elseif ($app['status'] === 'completed'): ?>
                                <div class="status-card-completed">
                                    <p class="status-text-completed"><strong>✓ Job Completed!</strong></p>
                                    <p>Payment has been processed. Thank you for your work!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </fieldset>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FreeMarket. All Rights Reserved.</p>
    </footer>

    <?php renderNavbarScript(); ?>
</body>
</html>
