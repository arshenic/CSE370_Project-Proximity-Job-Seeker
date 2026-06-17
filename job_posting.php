<?php
include "database.php";

$message = "";

if (isset($_POST['post_job'])) {

    $employer_id = $_POST['employer_id']; 
    $job_title = $_POST['job_title'];
    $start_date = $_POST['start_date'];
    $working_hours = $_POST['working_hours'];
    $working_days = $_POST['working_days'];
    $job_type = $_POST['job_type'];
    $job_period = $_POST['job_period'];
    $salary = $_POST['salary'];
    $pref_ed = $_POST['pref_ed'];
    $pref_age = $_POST['pref_age'];
    $req_cgpa = $_POST['req_cgpa'];
    $skills = $_POST['skills'];
    $description = $_POST['description'];
    $posting_date = date('Y-m-d');
    $expiry_date = $_POST['expiry_date'];

    
    $sql_job = "INSERT INTO Job 
        (JobTitle, StartDate, WorkingHours, PreferredEdBackground, PreferredAge, RequiredCGPA, Salary, JobType, JobPeriod, WorkingDays, Status, SkillsDescription, Description)
        VALUES 
        ('$job_title', '$start_date', '$working_hours', '$pref_ed', '$pref_age', '$req_cgpa', '$salary', '$job_type', '$job_period', '$working_days', 'Open', '$skills', '$description')";

    if (mysqli_query($conn, $sql_job)) {
        $job_id = mysqli_insert_id($conn); 

        
        $sql_offer = "INSERT INTO Offers (EmployerID, JobID, PostingDate, ExpiryDate)
            VALUES ('$employer_id', '$job_id', '$posting_date', '$expiry_date')";

        mysqli_query($conn, $sql_offer);

        $message = "success";
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
        <meta name="keywords" content="jobs, career, local jobs, job search, employment">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proximity Job Seeker: Post a Job</title>
    </head>

    <body style="background-color: black;">

        <h1 align="center" style="background-color: white;"><b> PROXIMITY JOB SEEKER </b></h1>
        <h2 align="center" style="color: white;">Find Career Opportunities at Your Doorstep</h2>
        <hr style="background-color: white;">

        <?php if ($message == "success"): ?>
            <h2 align="center" style="color: lightgreen;">✔ Job Posted Successfully!</h2>
            <p align="center"><a href="post_job.php" style="color: white;">Post Another Job</a></p>
            <p align="center"><a href="employer_dashboard.php" style="color: white;">Go to Dashboard</a></p>

        <?php else: ?>

            <?php if ($message != ""): ?>
                <h3 align="center" style="color: red;"><?php echo $message; ?></h3>
            <?php endif; ?>

            <h2 align="center" style="color: white;">Post a New Job</h2>

            <form action="post_job.php" method="POST">

                
                <input type="hidden" name="employer_id" value="1">

                <hr style="background-color: white;">
                <h3 style="color: white;">Job Information</h3>

                <label for="job_title" style="color: white;">Job Title:</label>
                <input type="text" id="job_title" name="job_title" required placeholder="e.g. Junior Software Engineer">
                <br><br>

                <label for="job_type" style="color: white;">Job Type:</label>
                <select id="job_type" name="job_type" required style="margin-left: 5px;">
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Internship">Internship</option>
                    <option value="Contract">Contract</option>
                </select>
                <br><br>

                <label for="job_period" style="color: white;">Job Period:</label>
                <input type="text" id="job_period" name="job_period" required placeholder="e.g. 1 Year, 6 Months">
                <br><br>

                <label for="salary" style="color: white;">Salary (BDT):</label>
                <input type="number" id="salary" name="salary" required placeholder="e.g. 40000">
                <br><br>

                <label for="start_date" style="color: white;">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
                <br><br>

                <label for="expiry_date" style="color: white;">Application Deadline:</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
                <br><br>

                <label for="working_hours" style="color: white;">Working Hours:</label>
                <input type="text" id="working_hours" name="working_hours" required placeholder="e.g. 9 AM - 5 PM">
                <br><br>

                <label for="working_days" style="color: white;">Working Days:</label>
                <input type="text" id="working_days" name="working_days" required placeholder="e.g. Sunday-Thursday">
                <br><br>

                <hr style="background-color: white;">
                <h3 style="color: white;">Candidate Requirements</h3>

                <label for="pref_ed" style="color: white;">Preferred Education:</label>
                <input type="text" id="pref_ed" name="pref_ed" placeholder="e.g. BSc in CSE">
                <br><br>

                <label for="pref_age" style="color: white;">Preferred Age:</label>
                <input type="number" id="pref_age" name="pref_age" placeholder="e.g. 25">
                <br><br>

                <label for="req_cgpa" style="color: white;">Required CGPA:</label>
                <input type="number" step="0.01" min="0" max="4" id="req_cgpa" name="req_cgpa" placeholder="e.g. 3.20">
                <br><br>

                <label for="skills" style="color: white;">Required Skills:</label>
                <br>
                <textarea id="skills" name="skills" rows="3" cols="50" placeholder="e.g. PHP, Laravel, MySQL"></textarea>
                <br><br>

                <hr style="background-color: white;">
                <h3 style="color: white;">Job Description</h3>

                <label for="description" style="color: white;">Description:</label>
                <br>
                <textarea id="description" name="description" rows="5" cols="50" placeholder="Describe the job role and responsibilities..."></textarea>
                <br><br>

                <input type="reset" value="Reset">
                <input type="submit" value="Post Job" name="post_job">

            </form>

            <br>
            <a href="employer_dashboard.php" target="_self">
                <h4 style="color: white;">Return to Dashboard</h4>
            </a>

        <?php endif; ?>

    </body>
</html>