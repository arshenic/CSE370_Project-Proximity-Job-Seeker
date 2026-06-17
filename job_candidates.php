<?php
session_start();
include "database.php";

if (!isset($_SESSION['employer_id']) || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['job_id'])) {
    echo "No job selected.";
    exit();
}

$employer_id = $_SESSION['employer_id'];
$employer_email = $_SESSION['email'];
$job_id = $_POST['job_id'];

$check_job = "
    SELECT Job.JobTitle
    FROM Offers
    JOIN Job ON Offers.JobID = Job.JobID
    WHERE Offers.EmployerID = '$employer_id'
    AND Job.JobID = '$job_id'
";

$check_result = mysqli_query($conn, $check_job);

if (mysqli_num_rows($check_result) == 0) {
    echo "This job does not belong to this employer.";
    exit();
}

$job = mysqli_fetch_assoc($check_result);

$query = "
    SELECT 
        Candidate.CandidateID,
        Candidate.Name,
        Candidate.Email,
        Candidate.Phone,
        Candidate.Gender,
        Candidate.DOB,
        Candidate.CGPA,
        Candidate.CurrentEdBackground,
        Candidate.CV,
        Candidate.Area,
        Applies.ApplicationDate
    FROM Applies
    JOIN Candidate ON Applies.CandidateID = Candidate.CandidateID
    WHERE Applies.JobID = '$job_id'
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
    <meta name="keywords" content="proximity, jobs, career, local jobs, job search, employment, hirer, job seeker">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Candidates</title>
</head>

<body style="background-color:black; color:white;">

<h1 align="center">Applied Candidates</h1>
<h2 align="center">Job: <?php echo $job['JobTitle']; ?></h2>

<hr>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

<div style="border:1px solid white; padding:15px; margin:20px;">

    <h2><?php echo $row['Name']; ?></h2>

    <p><b>Email:</b> <?php echo $row['Email']; ?></p>
    <p><b>Phone:</b> <?php echo $row['Phone']; ?></p>
    <p><b>Gender:</b> <?php echo $row['Gender']; ?></p>
    <p><b>DOB:</b> <?php echo $row['DOB']; ?></p>
    <p><b>CGPA:</b> <?php echo $row['CGPA']; ?></p>
    <p><b>Education:</b> <?php echo $row['CurrentEdBackground']; ?></p>
    <p><b>Area:</b> <?php echo $row['Area']; ?></p>
    
    <?php $query2= "SELECT AVG(Rating) AS AverageRating FROM Rates WHERE CandidateID='" . $row['CandidateID'] . "'";
                $result2 = mysqli_query($conn, $query2);
                $row2 = mysqli_fetch_array($result2);
                $AverageRating=0.0;
                if ($row2['AverageRating'] !== null) {
                    $AverageRating = round($row2['AverageRating'], 1);
                }
    ?>                
    <p><b>Rating:</b> <?php echo $AverageRating; ?></p>

    <p><b>Application Date:</b> <?php echo $row['ApplicationDate']; ?></p>

    <p>
        <b>CV:</b>
        <?php
        if ($row['CV'] != "") {
            echo "<a href='CV/".$row['CV']."' target='_blank' style='color:yellow;'>View CV</a>";
        } else {
            echo "No CV uploaded";
        }
        ?>
    </p>

    <form action="schedule_interview.php" method="POST">
        <input type="hidden" name="employer_email" value="<?php echo $employer_email; ?>">
        <input type="hidden" name="candidate_email" value="<?php echo $row['Email']; ?>">
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">

        <input type="submit" value="Schedule Interview">
    </form>

</div>

<?php
    }
} 
else {
    echo "<h3>No candidates have applied for this job yet.</h3>";
}
?>

<br>

<a href="job_offer_management.php" style="color:white;">Back to My Jobs</a>

</body>
</html>