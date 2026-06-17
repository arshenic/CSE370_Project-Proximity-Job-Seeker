<?php

    include "database.php";
    session_start();
    $email=$_SESSION['email'];
    $employer_id=$_SESSION['employer_id'];
   
?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Proximity Job Seeker - Find local jobs and career opportunities">
        <meta name="keywords" content="proximity, jobs, career, local jobs, job search, employment, hirer, job seeker">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Proximity Job Seeker: Employer Dashboard </title>
    </head>

    <body style="background-color: black;">
        
        <h1 align="center" style="background-color: white;"><b> Welcome to your Dashboard </b></h1>
        <br>
        
        <h2 align="center" style="color: white;"> Employer Dashboard: Hire Regional Skilled Professionals</h2>
        <br>
        

        <h2 align="center" style="color: white;"><b></b></h2>

        <img src="employer.jpg" title="default_employer" align="left" height="250" width="250">

        <br>
        <br>
        <br>
        <br>
        <h2 align="left" style="color: white;"><b><u>Office Information</u></b></h2>
        
        
        <?php
            if (!isset($_SESSION['email'])) {
                echo "<h3 align='center' style='color: white;'>No user logged in.</h3>";
                exit();
            }

            $query1="SELECT * FROM Employer WHERE Email='$email'";

            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_array($result1);
            
            $_SESSION['email'] = $row1['Email'];
            $_SESSION['employer_id'] = $row1['EmployerID'];
           
            echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row1['Name'] . "</i>  |  <b>Email:</b> <i>" . $row1['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row1['Phone'] . "</i></h3>";
           
            
            
            echo "<h3 align='left' style='color: white;'><b>Housing:</b> <i>" . $row1['Housing'] . "</i>  |  <b>Street:</b> <i>" . $row1['Street'] . "</i>  |  <b>Area:</b> <i>" . $row1['Area'] . "</i> | <b>City:</b> <i>" . $row1['City'] . "</i> | <b>Postal Code:</b> <i>" . $row1['PostalCode'] . "</i></h3>";
            
       ?>
       <br>
       <br>
       <br>
       <br>
       <br>
       
       
       <a href="logout.php" style="color:white;">Click to Logout</a>

       

        <form action="job_management.php" method="POST">
            <input type="submit" name="job_management" value="Manage Hired Employees";>
        </form>
        
        

        <form action="job_posting.php" method="POST">
            <input type="submit" name="job_posting" value="Offer New Job";>
        </form>

        

        <form align="left" action="job_offer_management.php" method="POST">
            <input type="submit" name="job_offer_management" value="Manage Job Listings";>
            
        </form>

       

       <hr style="background-color: white;">

       <h2 align="center" style="color: white;"><b><u>Hired Employees</u></b></h2>
        <?php
            

            $query2 = "SELECT c.CandidateID, c.Name, c.Email, c.Phone, 
                       j.JobTitle, j.JobType, j.WorkingDays, j.WorkingHours, j.Salary, 
                       h.StartingDate FROM Employer e, Candidate c, Job j, Hired h, Offers o 
                       WHERE e.EmployerID = '" . $row1['EmployerID'] . "' AND e.EmployerID = o.EmployerID AND o.JobID = j.JobID AND h.CandidateID = c.CandidateID AND h.JobID = j.JobID";
            $result2 = mysqli_query($conn, $query2);
            while ($row2 = mysqli_fetch_array($result2)) {
                echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row2['Name'] . "</i>  |  <b>Email:</b> <i>" . $row2['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row2['Phone'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Job Title:</b> <i>" . $row2['JobTitle'] . "</i>  |  <b>Job Type:</b> <i>" . $row2['JobType'] . "</i>  |  <b>Working Days:</b> <i>" . $row2['WorkingDays'] . "</i> | <b>Working Hours:</b> <i>" . $row2['WorkingHours'] . "</i> | <b>Salary:</b> <i>" . $row2['Salary'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Starting Date:</b> <i>" . $row2['StartingDate'] . "</i></h3>";
                
                //rating system 

                $query3 = "SELECT count(*) as total FROM Rates WHERE EmployerID = '" . $row1['EmployerID'] . "' AND CandidateID = '" . $row2['CandidateID'] . "'";
                $result3 = mysqli_query($conn, $query3);
                $row3 = mysqli_fetch_array($result3);
                if($row3['total'] == 0) {
                    
                    echo "<form align='right' style='color: white;' action='employer_dashboard.php' method='POST'>
                    <input type='hidden' name='candidate_id' value='" . $row2['CandidateID'] . "'>
                    <input type='number' name='rate' placeholder='Rate 0-5' step='0.1' min='0' max='5' required>
                    <input type='submit' name='submit_rating' value='Submit Rating'>
                    </form>";
                } 
                else {
                    echo "<h3 align='right' style='color: white;'>You have already rated this candidate.</h3>";
                }

            }


            if(isset($_POST['submit_rating'])){
                $rating = $_POST['rate'];
                $employer_id = $row1['EmployerID'];
                $candidate_id = $_POST['candidate_id'];
                $rate_sql = "INSERT INTO Rates (EmployerID, CandidateID, Rating) VALUES ('$employer_id', '$candidate_id', '$rating')";
                if (mysqli_query($conn, $rate_sql)) {
                    echo "<h3 style='color: green;'>Candidate rating submitted successfully!</h3>";
                    
                } 
                else {
                     echo "<h3 style='color: red;'>Error: " . mysqli_error($conn) . "</h3>";
                }
            }
        ?>

        <hr style="background-color: white;">
        
        <h2 align="center" style="color: white;"><b><u>Scheduled Interviews</u></b></h2>
        <?php
        
            $query4 = "SELECT c.CandidateID, c.Name, c.Email, c.Phone, c.NID, c.CGPA, c.CurrentEdBackground, c.CV, c.Area, c.Gender,j.JobID,
                       j.JobTitle, j.JobType, j.Salary,j.StartDate,i.InterviewDate 
                       FROM Employer e, Candidate c, Job j, Interview i 
                       WHERE e.Email = '".$row1['Email']."' AND c.CandidateID = i.CandidateID AND i.EmployerID = e.EmployerID AND i.JobID = j.JobID AND j.Status='Open'"; 
            

            $result4 = mysqli_query($conn, $query4);
            while ($row4 = mysqli_fetch_array($result4)) {
                echo "<h3 align='left' style='color: white;'><b>Name:</b> <i>" . $row4['Name'] . "</i>  |  <b>Email:</b> <i>" . $row4['Email'] . "</i>  |  <b>Phone:</b> <i>" . $row4['Phone'] . "</i> | <b>NID:</b> <i>" . $row4['NID'] . "</i> | <b>Gender:</b> <i>" . $row4['Gender'] . "</i> | <b>Area:</b> <i>" . $row4['Area'] . "</i></h3>";
                echo "<h3 align='left' style='color: white;'><b>Job Title:</b> <i>" . $row4['JobTitle'] . "</i>  |  <b>Job Type:</b> <i>" . $row4['JobType'] . "</i> | <b>Salary:</b> <i>" . $row4['Salary'] . "</i> | <b>Start Date:</b> <i>" . $row4['StartDate'] . "</i></h3>";
                
                
                $query5= "SELECT AVG(Rating) AS AverageRating FROM Rates WHERE CandidateID='" . $row4['CandidateID'] . "'";
                $result5 = mysqli_query($conn, $query5);
                $row5 = mysqli_fetch_array($result5);
                $AverageRating=0.0;
                if ($row5['AverageRating'] !== null) {
                    $AverageRating = round($row5['AverageRating'], 1);
                }
                echo "<h3 align='left' style='color: white;'><b>Current Education:</b> <i>" . $row4['CurrentEdBackground'] . "</i> | <b>CGPA:</b> <i>" . $row4['CGPA'] . "</i>| <b>Rating:</b> <i>" . $AverageRating . "</i></h3>";
                echo "<a href='CV/" . $row4['CV'] . "' target='_blank'>  <h3 align='left' style='color: white;'><b>CV:</b> <i>" . $row4['CV'] . "</i></h3></a>";
                echo "<h3 align='left' style='color: white;'><b>Interview Date:</b> <i>" . $row4['InterviewDate'] . "</i></h3>";


                echo "<form align='right' style='color: white;' action='employer_dashboard.php' method='POST'>
                <input type='hidden' name='candidate_id' value='" . $row4['CandidateID'] . "'>
                <input type='hidden' name='job_id' value='" . $row4['JobID'] . "'>
                <input type='submit' name='hire_candidate' value='Hire'>
                </form>";



            }

             if(isset($_POST['hire_candidate'])){
                $candidate_id = $_POST['candidate_id'];
                $job_id = $_POST['job_id'];
                $starting_date = date('Y-m-d');
                
                $hire_sql = "INSERT INTO Hired (CandidateID, JobID, StartingDate) VALUES ('$candidate_id', '$job_id', '$starting_date')";
                $update_job_sql = "UPDATE Job SET JobStatus = 'Closed' WHERE JobID = '$job_id'";
                
                if (mysqli_query($conn, $hire_sql) && mysqli_query($conn, $update_job_sql)) {
                    echo "<h3 style='color: green;'>Candidate hired successfully!</h3>";
                } 
                else {
                     echo "<h3 style='color: red;'>Error: " . mysqli_error($conn) . "</h3>";
                }
            }




        ?>


       


       
        
        
        
       



       
        
    </body>
</html>