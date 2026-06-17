<?php

    include "database.php";
    session_start();
   
?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
        <meta name="keywords" content="proximity, jobs, career, local jobs, job search, employment, hirer, job seeker">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Proximity Job Seeker: Candidate Dashboard </title>
    </head>

    <body style="background-color: black;">
        
        <h1 align="center" style="background-color: white;"><b> Welcome to your Dashboard </b></h1>
        <h2 align="center" style="color: white;"> Find Career Opportunities at Your Doorstep</h2>
        <br>
        <br>
        <br>

        <h2 align="center" style="color: white;"><b>Candidate Dashboard: Find Jobs At Your Doorstep</b></h2>

        <img src="candidate.jpg" title="default_candidate" align="left" height="250" width="250">

        
        
        <h2 align="left" style="color: white;"><b><u>Personal Information</u></b></h2>
        
        
        <?php
            if (!isset($_SESSION['email'])) {
                echo "<h3 align='center' style='color: white;'>No user logged in.</h3>";
                exit();
            }


            $query1="SELECT * FROM Candidate WHERE Email='".$_SESSION['email']."'";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_array($result1);
            $_SESSION['email'] = $row1['Email'];
            $_SESSION['candidate_id'] = $row1['CandidateID'];


            
            $query2= "SELECT AVG(Rating) AS AverageRating FROM Rates WHERE CandidateID='" . $row1['CandidateID'] . "'";
            $result2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_array($result2);
            
            $AverageRating=0.0;
            if ($row2['AverageRating'] !== null) {
                $AverageRating = round($row2['AverageRating'], 1);
            }

    

            echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row1['Name'] . "</i>  |  <b>Email:</b> <i>" . $row1['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row1['Phone'] . "</i></h3>";
            echo "<h3 align='left' style='color: white;'><b>Date of Birth:</b> <i>" . $row1['DOB'] . "</i>  |  <b>NID:</b> <i>" . $row1['NID'] . "</i>  |  <b>Gender:</b> <i>" . $row1['Gender'] . "</i></h3>";
            echo "<h3 align='left' style='color: white;'><b>Current Education:</b> <i>" . $row1['CurrentEdBackground'] . "</i>  |  <b>CGPA:</b> <i>" . $row1['CGPA'] . "</i> | <b>Rating:</b> <i>" . $AverageRating . "</i></h3>";
            echo "<a href='CV/" . $row1['CV'] . "' target='_blank'>  <h3 align='left' style='color: white;'><b>CV:</b> <i>" . $row1['CV'] . "</i></h3></a>";
            echo "<h3 align='left' style='color: white;'><b>Area:</b> <i>" . $row1['Area'] . "</i></h3>";
            
            


       ?>

       <br> 
       <a href="logout.php" target="_self" title="Proximity Job Seeker">
            <h4 style="color: white;">Click to Logout</h4>
       </a>
       
       <form align="right" action="update_cv.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="new_cv" accept=".pdf,.doc,.docx" required>
            <input type="submit" name="upload_cv" value="Update CV">
        </form>
        <br>

        <form action="search_jobs.php" method="POST">
            <input type="submit" name="job_apply" value="Look for Jobs">
        </form>
 
       <hr style="background-color: white;">

       <h2 align="center" style="color: white;"><b><u>Current Jobs</u></b></h2>
        <?php
        
            $query3 = "SELECT e.EmployerID, e.Name, e.Email, e.Phone, e.Housing, e.Street, e.Area, e.City, e.PostalCode,
                       j.JobTitle, j.JobType, j.WorkingDays, j.WorkingHours, j.Salary, h.StartingDate 
                       FROM Employer e, Candidate c, Job j, Hired h, Offers o 
                       WHERE c.Email = '".$row1['Email']."' AND c.CandidateID = h.CandidateID AND h.JobID = j.JobID AND j.JobID = o.JobID AND o.EmployerID = e.EmployerID"; 
                       
            $result3 = mysqli_query($conn, $query3);
            while ($row3 = mysqli_fetch_array($result3)) {
                echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row3['Name'] . "</i>  |  <b>Email:</b> <i>" . $row3['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row3['Phone'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Job Title:</b> <i>" . $row3['JobTitle'] . "</i>  |  <b>Job Type:</b> <i>" . $row3['JobType'] . "</i>  |  <b>Working Days:</b> <i>" . $row3['WorkingDays'] . "</i> | <b>Working Hours:</b> <i>" . $row3['WorkingHours'] . "</i> | <b>Salary:</b> <i>" . $row3['Salary'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Starting Date:</b> <i>" . $row3['StartingDate'] . "</i></h3>";
            }
        ?>


        <hr style="background-color: white;">

        <h2 align="center" style="color: white;"><b><u>Scheduled Interviews</u></b></h2>
        <?php
        
            $query4 = "SELECT e.EmployerID, e.Name, e.Email, e.Phone, e.Housing, e.Street, e.Area, e.City, e.PostalCode,
                       j.JobTitle, j.JobType, j.Salary,j.StartDate,i.InterviewDate 
                       FROM Employer e, Candidate c, Job j, Interview i 
                       WHERE c.Email = '".$row1['Email']."' AND c.CandidateID = i.CandidateID AND i.EmployerID = e.EmployerID AND i.JobID = j.JobID AND j.Status='Open'"; 
                       
            $result4 = mysqli_query($conn, $query4);
            while ($row4 = mysqli_fetch_array($result4)) {
                echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row4['Name'] . "</i>  |  <b>Email:</b> <i>" . $row4['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row4['Phone'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Office Address:</b> <i>" . $row4['Housing'] . ", " . $row4['Street'] . ", " . $row4['Area'] . ", " . $row4['City'] . ", " . $row4['PostalCode'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Job Title:</b> <i>" . $row4['JobTitle'] . "</i>  |  <b>Job Type:</b> <i>" . $row4['JobType'] . "</i> | <b>Salary:</b> <i>" . $row4['Salary'] . "</i> | <b>Start Date:</b> <i>" . $row4['StartDate'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Interview Date:</b> <i>" . $row4['InterviewDate'] . "</i></h3>";
            }
        ?>
    </body>
</html>