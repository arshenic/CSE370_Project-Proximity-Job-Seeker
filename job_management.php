<?php
session_start();
include "database.php";
$email=$_SESSION['email'];
$employer_id = $_SESSION['employer_id'];

if (!isset($_SESSION['email']) || !isset($_SESSION['employer_id'])) {
    header("Location: index.php");
    exit();
}


$message = "";

if (isset($_POST['update_job'])) {
    $job_id = $_POST['job_id'];
    $status = $_POST['status'];
    $working_days = $_POST['working_days'];
    $working_hours = $_POST['working_hours'];
    $salary = $_POST['salary'];

    $sql = "
        UPDATE Job
        SET 
            Status = '$status',
            WorkingDays = '$working_days',
            WorkingHours = '$working_hours',
            Salary = '$salary'
        WHERE JobID = '$job_id'
    ";

    if (mysqli_query($conn, $sql)) {
        $message = "Job information updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$query = "
    SELECT 
        Candidate.Name,
        Candidate.Email,
        Candidate.Phone,
        Candidate.CGPA,
        Job.JobID,
        Job.JobTitle,
        Job.JobType,
        Job.WorkingDays,
        Job.WorkingHours,
        Job.Salary,
        Job.Status,
        Hired.StartingDate
    FROM Hired
    JOIN Candidate ON Hired.CandidateID = Candidate.CandidateID
    JOIN Job ON Hired.JobID = Job.JobID
    JOIN Offers ON Job.JobID = Offers.JobID
    WHERE Offers.EmployerID = '$employer_id'
";

$result = mysqli_query($conn, $query);

?>




<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
    <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
    <meta name="keywords" content="jobs, career, local jobs, job search, employment">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Job Management </title>

</head>

<body style="background-color:black; color:white;">

    <h2 align="center">Job Management</h2>
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

    <h2>Hired Employee</h2>

    <p>
        <b>Name:</b> <?php echo $row['Name']; ?> |
        <b>Email:</b> <?php echo $row['Email']; ?> |
        <b>Phone:</b> <?php echo $row['Phone']; ?>
    </p>

    <p>
        <b>CGPA:</b> <?php echo $row['CGPA']; ?>
        
    </p>

    <p>
        <b>Job Title:</b> <?php echo $row['JobTitle']; ?> |
        <b>Job Type:</b> <?php echo $row['JobType']; ?>
    </p>

    <p>
        <b>Starting Date:</b> <?php echo $row['StartingDate']; ?>
    </p>

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

</div>

<?php
    }
} else {
    echo "<h3>No hired employees found for this employer.</h3>";
}
?>

<br>

<a href="employer_dashboard.php" style="color:white;">
    Back to Employer Dashboard
</a>





<br>



</body>
</html>