<?php
if (isset($_POST['job_id'])) {
    $jobId = $_POST['job_id'];
    require_once("../model/jobModel.php");
    require_once("../model/applicationModel.php");
    
    $jobDetails = searchJobsByJobID($jobId);
    
    if (!empty($jobDetails)) {
        // Get applications for this job
        $applications = fetchFreelancerApplications($jobId);
        
        // Check if job has accepted applications or work in progress
        $hasAcceptedApplications = false;
        $hasPendingApplications = false;
        
        foreach ($applications as $app) {
            if ($app['status'] === 'accepted' || $app['status'] === 'work_submitted' || $app['status'] === 'completed') {
                $hasAcceptedApplications = true;
            }
            if ($app['status'] === 'pending') {
                $hasPendingApplications = true;
            }
        }
        
        // Add application info to job details
        $jobDetails[0]['has_accepted_applications'] = $hasAcceptedApplications;
        $jobDetails[0]['has_pending_applications'] = $hasPendingApplications;
        $jobDetails[0]['total_applications'] = count($applications);
    }
    
    $jobJson = json_encode($jobDetails);
    echo $jobJson;
} else {
    echo "No job ID provided.";
}
?>
