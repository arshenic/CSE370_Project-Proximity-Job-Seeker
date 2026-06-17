<?php
session_start();
include "database.php";

if (!isset($_SESSION['candidate_id'])) {
    header("Location: index.php");
    exit();
}

$candidate_id = $_SESSION['candidate_id'];


$candidate_sql = "SELECT Area FROM Candidate WHERE CandidateID = '$candidate_id'";
$candidate_result = mysqli_query($conn, $candidate_sql);
$candidate = mysqli_fetch_assoc($candidate_result);

$candidate_area = $candidate['Area'];


$salary_min = isset($_POST['salary_min']) ? $_POST['salary_min'] : "";
$salary_max = isset($_POST['salary_max']) ? $_POST['salary_max'] : "";
$job_type = isset($_POST['job_type']) ? $_POST['job_type'] : "";
$job_period = isset($_POST['job_period']) ? $_POST['job_period'] : "";
$pref_ed = isset($_POST['pref_ed']) ? $_POST['pref_ed'] : "";
$req_cgpa = isset($_POST['req_cgpa']) ? $_POST['req_cgpa'] : "";
$working_days = isset($_POST['working_days']) ? $_POST['working_days'] : "";


$selected_job_id = isset($_GET['job_id']) ? $_GET['job_id'] : "";


$sql = "SELECT Job.*, Employer.Name AS EmployerName, Employer.City, Employer.Area 
        FROM Job 
        JOIN Offers ON Job.JobID = Offers.JobID 
        JOIN Employer ON Offers.EmployerID = Employer.EmployerID
        WHERE Job.Status = 'Open'
        AND Employer.Area = '$candidate_area'";

if ($salary_min != "") {
    $sql .= " AND Job.Salary >= '$salary_min'";
}
if ($salary_max != "") {
    $sql .= " AND Job.Salary <= '$salary_max'";
}
if ($job_type != "") {
    $sql .= " AND Job.JobType = '$job_type'";
}
if ($job_period != "") {
    $sql .= " AND Job.JobPeriod = '$job_period'";
}
if ($pref_ed != "") {
    $sql .= " AND Job.PreferredEdBackground LIKE '%$pref_ed%'";
}
if ($req_cgpa != "") {
    $sql .= " AND Job.RequiredCGPA <= '$req_cgpa'";
}
if ($working_days != "") {
    $sql .= " AND Job.WorkingDays = '$working_days'";
}

$result = mysqli_query($conn, $sql);


$selected_job = null;

if ($selected_job_id != "") {
    $job_sql = "SELECT Job.*, Employer.Name AS EmployerName, Employer.City, Employer.Area, Employer.Street, Employer.Housing
                FROM Job 
                JOIN Offers ON Job.JobID = Offers.JobID 
                JOIN Employer ON Offers.EmployerID = Employer.EmployerID
                WHERE Job.JobID = '$selected_job_id'
                AND Employer.Area = '$candidate_area'
                AND Job.Status = 'Open'";

    $job_result = mysqli_query($conn, $job_sql);
    $selected_job = mysqli_fetch_assoc($job_result);
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
    <meta name="keywords" content="proximity, jobs, career, local jobs, job search, employment, hirer, job seeker">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proximity Job Seeker: Search Jobs</title>
</head>

<body style="background-color: black;">

    
   

    <h2 align="center" style="color: white;">Search Jobs</h2>

    <hr style="background-color: white;">
    
    

    
    <form action="search_jobs.php" method="POST">

        <h3 style="color: white;">Filter Jobs</h3>

        
        <label style="color: white;">Salary Range (BDT):</label>
        <br>
        <label style="color: white;">Min:</label>
        <input type="number" name="salary_min" placeholder="e.g. 10000" value="<?php echo $salary_min; ?>">
        <label style="color: white;">Max:</label>
        <input type="number" name="salary_max" placeholder="e.g. 50000" value="<?php echo $salary_max; ?>">
        <br><br>

        
        <label style="color: white;">Job Type:</label>
        <select name="job_type">
            <option value="">-- All --</option>
            <option value="Full-time" <?php if($job_type == "Full-time") echo "selected"; ?>>Full-time</option>
            <option value="Part-time" <?php if($job_type == "Part-time") echo "selected"; ?>>Part-time</option>
            <option value="Internship" <?php if($job_type == "Internship") echo "selected"; ?>>Internship</option>
            <option value="Contract" <?php if($job_type == "Contract") echo "selected"; ?>>Contract</option>
        </select>
        <br><br>

        
        <label style="color: white;">Job Period:</label>
        <select name="job_period">
            <option value="">-- All --</option>
            <option value="6 Months" <?php if($job_period == "6 Months") echo "selected"; ?>>6 Months</option>
            <option value="8 Months" <?php if($job_period == "8 Months") echo "selected"; ?>>8 Months</option>
            <option value="1 Year" <?php if($job_period == "1 Year") echo "selected"; ?>>1 Year</option>
            <option value="2 Years" <?php if($job_period == "2 Years") echo "selected"; ?>>2 Years</option>
        </select>
        <br><br>

        
        <label style="color: white;">Preferred Education Background:</label>
        <select name="pref_ed">
            <option value="">-- All --</option>
            <option value="BSc in CSE" <?php if($pref_ed == "BSc in CSE") echo "selected"; ?>>BSc in CSE</option>
            <option value="BSc in EEE" <?php if($pref_ed == "BSc in EEE") echo "selected"; ?>>BSc in EEE</option>
            <option value="BBA" <?php if($pref_ed == "BBA") echo "selected"; ?>>BBA</option>
            <option value="MBA" <?php if($pref_ed == "MBA") echo "selected"; ?>>MBA</option>
            <option value="BSc in Civil" <?php if($pref_ed == "BSc in Civil") echo "selected"; ?>>BSc in Civil</option>
        </select>
        <br><br>

        
        <label style="color: white;">My CGPA (shows jobs I qualify for):</label>
        <input type="number" step="0.01" min="0" max="4" name="req_cgpa" placeholder="e.g. 3.50" value="<?php echo $req_cgpa; ?>">
        <br><br>

        
        <label style="color: white;">Working Days:</label>
        <select name="working_days">
            <option value="">-- All --</option>
            <option value="Sunday-Thursday" <?php if($working_days == "Sunday-Thursday") echo "selected"; ?>>Sunday-Thursday</option>
            <option value="Saturday-Wednesday" <?php if($working_days == "Saturday-Wednesday") echo "selected"; ?>>Saturday-Wednesday</option>
            <option value="Sunday-Wednesday" <?php if($working_days == "Sunday-Wednesday") echo "selected"; ?>>Sunday-Wednesday</option>
            <option value="Monday-Friday" <?php if($working_days == "Monday-Friday") echo "selected"; ?>>Monday-Friday</option>
        </select>
        <br><br>

        <input type="submit" value="Search">
        <a href="search_jobs.php" style="color: white; margin-left: 15px;">Clear Filters</a>

    </form>

    <hr style="background-color: white;">

    
    <h3 style="color: white;">Available Jobs</h3>
    <h3 align="left" style="color: white;">
    Showing jobs in your area: <?php echo $candidate_area; ?>
    </h3>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <p style="color: red;">No jobs found matching your filters.</p>
    <?php else: ?>
        <table border="1" style="color: white; border-collapse: collapse; width: 90%;">
            <tr style="background-color: white; color: black;">
                <th style="padding: 8px;">Job Title</th>
                <th style="padding: 8px;">Company</th>
                <th style="padding: 8px;">Location</th>
                <th style="padding: 8px;">Job Type</th>
                <th style="padding: 8px;">Period</th>
                <th style="padding: 8px;">Salary (BDT)</th>
                <th style="padding: 8px;">Working Days</th>
                <th style="padding: 8px;">Required CGPA</th>
                <th style="padding: 8px;">Preferred Education</th>
                <th style="padding: 8px;">Details</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="padding: 8px;"><?php echo $row['JobTitle']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['EmployerName']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['Area'] . ", " . $row['City']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['JobType']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['JobPeriod']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['Salary']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['WorkingDays']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['RequiredCGPA']; ?></td>
                    <td style="padding: 8px;"><?php echo $row['PreferredEdBackground']; ?></td>
                    <td style="padding: 8px;">
                        <a href="search_jobs.php?job_id=<?php echo $row['JobID']; ?>" style="color: lightblue;">View Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    
    <?php if ($selected_job): ?>
        <hr style="background-color: white;">
        <h3 style="color: white;">Job Details</h3>

        <table border="1" style="color: white; border-collapse: collapse; width: 60%;">
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Job Title</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['JobTitle']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Company</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['EmployerName']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Location</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['Housing'] . ", " . $selected_job['Street'] . ", " . $selected_job['Area'] . ", " . $selected_job['City']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Job Type</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['JobType']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Job Period</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['JobPeriod']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Salary (BDT)</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['Salary']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Working Hours</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['WorkingHours']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Working Days</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['WorkingDays']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Start Date</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['StartDate']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Preferred Education</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['PreferredEdBackground']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Preferred Age</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['PreferredAge']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Required CGPA</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['RequiredCGPA']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Required Skills</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['SkillsDescription']; ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; background-color: #333;"><b>Description</b></td>
                <td style="padding: 8px;"><?php echo $selected_job['Description']; ?></td>
            </tr>
        </table>
        <br>

        <form action="job_apply.php" method="POST">
            <input type="hidden" name="job_id" value="<?php echo $selected_job['JobID']; ?>">
            <input type="submit" value="Apply for this Job">
        </form>



    <?php endif; ?>

    <br>
    <a href="candidate_dashboard.php" style="color: white;">
        <h4>Return to Dashboard</h4>
    </a>

</body>
</html>