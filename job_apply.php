<?php
session_start();
include "database.php";

if (!isset($_SESSION['candidate_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['job_id'])) {
    echo "No job selected.";
    exit();
}

$candidate_id = $_SESSION['candidate_id'];
$job_id = $_POST['job_id'];
$message = "";


$job_check = "
    SELECT Job.JobID, Job.JobTitle, Job.Status
    FROM Job
    WHERE Job.JobID = '$job_id'
    AND Job.Status = 'Open'
";

$job_result = mysqli_query($conn, $job_check);

if (mysqli_num_rows($job_result) == 0) {
    echo "This job is not available for application.";
    exit();
}

$job = mysqli_fetch_assoc($job_result);


$check_apply = "
    SELECT * FROM Applies
    WHERE CandidateID = '$candidate_id'
    AND JobID = '$job_id'
";

$check_result = mysqli_query($conn, $check_apply);

if (mysqli_num_rows($check_result) > 0) {
    $message = "You have already applied for this job.";
} else {
    $application_date = date("Y-m-d");

    $apply_sql = "
        INSERT INTO Applies (CandidateID, JobID, ApplicationDate)
        VALUES ('$candidate_id', '$job_id', '$application_date')
    ";

    if (mysqli_query($conn, $apply_sql)) {
        $message = "Application submitted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
    <meta name="keywords" content="proximity, jobs, career, local jobs, job search, employment, hirer, job seeker">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Job</title>
</head>

<body style="background-color:black; color:white;">

<h1 align="center">Apply for Job</h1>
<hr>

<h2>Job Title: <?php echo $job['JobTitle']; ?></h2>

<h3 style="color:yellow;">
    <?php echo $message; ?>
</h3>

<br>

<a href="search_jobs.php" style="color:white;">
    Back to Search Jobs
</a>

<br><br>

<a href="candidate_dashboard.php" style="color:white;">
    Back to Candidate Dashboard
</a>

</body>
</html>