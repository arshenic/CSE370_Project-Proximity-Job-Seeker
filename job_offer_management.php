<?php
session_start();
include "database.php";

if (!isset($_SESSION['employer_id'])) {
    header("Location: index.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];
$message = "";

if (isset($_POST['update_job'])) {
    $job_id = $_POST['job_id'];
    $status = $_POST['status'];
    $working_days = $_POST['working_days'];
    $working_hours = $_POST['working_hours'];
    $salary = $_POST['salary'];

    $update = "
        UPDATE Job
        JOIN Offers ON Job.JobID = Offers.JobID
        SET 
            Job.Status = '$status',
            Job.WorkingDays = '$working_days',
            Job.WorkingHours = '$working_hours',
            Job.Salary = '$salary'
        WHERE Job.JobID = '$job_id'
        AND Offers.EmployerID = '$employer_id'
    ";

    if (mysqli_query($conn, $update)) {
        $message = "Job updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$query = "
    SELECT 
        Job.JobID,
        Job.JobTitle,
        Job.JobType,
        Job.WorkingDays,
        Job.WorkingHours,
        Job.Salary,
        Job.Status,
        Offers.PostingDate,
        Offers.ExpiryDate
    FROM Offers
    JOIN Job ON Offers.JobID = Job.JobID
    WHERE Offers.EmployerID = '$employer_id'
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
    <title>Manage My Jobs</title>
</head>

<body style="background-color:black; color:white;">

<h1 align="center">Job List Management</h1>
<h3 align="center">My Offered Jobs</h3>

<hr>

<?php
if ($message != "") {
    echo "<h3 style='color:yellow;'>$message</h3>";
}
?>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

<div style="border:1px solid white; padding:15px; margin:20px;">

    <h2><?php echo $row['JobTitle']; ?></h2>

    <p><b>Job Type:</b> <?php echo $row['JobType']; ?></p>
    <p><b>Status:</b> <?php echo $row['Status']; ?></p>
    <p><b>Working Days:</b> <?php echo $row['WorkingDays']; ?></p>
    <p><b>Working Hours:</b> <?php echo $row['WorkingHours']; ?></p>
    <p><b>Salary:</b> <?php echo $row['Salary']; ?></p>
    <p><b>Posting Date:</b> <?php echo $row['PostingDate']; ?></p>
    <p><b>Expiry Date:</b> <?php echo $row['ExpiryDate']; ?></p>

    <hr>

    <h3>Update Job Information</h3>

    <form method="POST">
        <input type="hidden" name="job_id" value="<?php echo $row['JobID']; ?>">

        <label>Status:</label>
        <select name="status">
            <option value="Open" <?php if ($row['Status'] == "Open") echo "selected"; ?>>Open</option>
            <option value="Closed" <?php if ($row['Status'] == "Closed") echo "selected"; ?>>Closed</option>
        </select>

        <br><br>

        <label>Working Days:</label>
        <input type="text" name="working_days" value="<?php echo $row['WorkingDays']; ?>">

        <br><br>

        <label>Working Hours:</label>
        <input type="text" name="working_hours" value="<?php echo $row['WorkingHours']; ?>">

        <br><br>

        <label>Salary:</label>
        <input type="number" name="salary" value="<?php echo $row['Salary']; ?>">

        <br><br>

        <input type="submit" name="update_job" value="Update Job">
    </form>

    <br>

    <form action="job_candidates.php" method="POST">
        <input type="hidden" name="job_id" value="<?php echo $row['JobID']; ?>">
        <input type="submit" value="View Applied Candidates">
    </form>

</div>

<?php
    }
} else {
    echo "<h3>You have not offered any jobs yet.</h3>";
}
?>

<br>

<a href="employer_dashboard.php" style="color:white;">Back to Employer Dashboard</a>

</body>
</html>
