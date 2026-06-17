<?php
session_start();
include "database.php";

$message = "";

if (!isset($_SESSION['employer_id']) || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['candidate_email']) || !isset($_POST['job_id'])) {
    echo "Required information missing.";
    exit();
}

$employer_id = $_SESSION['employer_id'];
$employer_email = $_SESSION['email'];

$candidate_email = $_POST['candidate_email'];
$job_id = $_POST['job_id'];

/* Find CandidateID */
$candidate_query = "SELECT CandidateID, Name FROM Candidate WHERE Email = '$candidate_email'";
$candidate_result = mysqli_query($conn, $candidate_query);

if (mysqli_num_rows($candidate_result) == 0) {
    echo "Candidate not found.";
    exit();
}

$candidate = mysqli_fetch_assoc($candidate_result);
$candidate_id = $candidate['CandidateID'];
$candidate_name = $candidate['Name'];

/* Check if this job belongs to logged-in employer */
$offer_query = "
    SELECT * FROM Offers
    WHERE EmployerID = '$employer_id'
    AND JobID = '$job_id'
";

$offer_result = mysqli_query($conn, $offer_query);

if (mysqli_num_rows($offer_result) == 0) {
    echo "This job does not belong to this employer.";
    exit();
}

/* Schedule interview */
if (isset($_POST['schedule'])) {

    $interview_date = $_POST['interview_date'];

    $insert_query = "
        INSERT INTO Interview (EmployerID, CandidateID, JobID, InterviewDate)
        VALUES ('$employer_id', '$candidate_id', '$job_id', '$interview_date')
        ON DUPLICATE KEY UPDATE InterviewDate = '$interview_date'
    ";

    if (mysqli_query($conn, $insert_query)) {
        $message = "Interview scheduled successfully!";
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
    <title>Schedule Interview</title>
</head>

<body style="background-color:black; color:white;">

<h2 align="center">Schedule Interview</h2>
<hr>

<?php
if ($message != "") {
    echo "<h3 style='color:yellow;'>$message</h3>";
}
?>

<p><b>Employer Email:</b> <?php echo $employer_email; ?></p>
<p><b>Candidate Name:</b> <?php echo $candidate_name; ?></p>
<p><b>Candidate Email:</b> <?php echo $candidate_email; ?></p>
<p><b>Job ID:</b> <?php echo $job_id; ?></p>

<form method="POST">

    <input type="hidden" name="candidate_email" value="<?php echo $candidate_email; ?>">
    <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">

    <label>Interview Date:</label>
    <input type="date" name="interview_date" required>

    <br><br>

    <input type="submit" name="schedule" value="Schedule Interview">

</form>

<br>

<a href="job_offer_management.php" style="color:white;">Back to Job List</a>

</body>
</html>