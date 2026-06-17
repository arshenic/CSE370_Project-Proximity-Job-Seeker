<?php
    session_start();
    include "database.php";
    
    

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        
        $password = $_POST['password'];
        $user_type=$_POST['user_type'];

        if($user_type=="candidate"){
            $query1="SELECT * FROM Candidate WHERE Email='$email' and Password='$password'";
            $result1 = mysqli_query($conn, $query1);
            $row1 = mysqli_fetch_assoc($result1);
            $count1=mysqli_num_rows($result1);

            if($count1== 1){
                $_SESSION['email'] = $email;
                $_SESSION['candidate_id'] = $row1['Candidate_ID'];
                header("Location: candidate_dashboard.php");
                exit();
            }

            else{
                 echo "<h3 style='color: white;'>Invalid email/password or user type</h3>";
            }
        }


        else if($user_type=="employer"){
            $query2= "SELECT * FROM Employer WHERE Email='$email' and Password='$password'";
            $result2 = mysqli_query($conn, $query2);
            $count2=mysqli_num_rows($result2);
            $row2 = mysqli_fetch_assoc($result2);
            if($count2== 1){
                $_SESSION['employer_id'] = $row2['Employer_ID'];
                $_SESSION['email'] = $email;
                header("Location: employer_dashboard.php");
                exit();
            }

            else{
                echo "<h3 style='color: white;'>Invalid email/password or user type</h3>";
            }


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
        <title> Proximity Job Seeker </title>
    </head>
    

    <body style="background-color: black;">
        <a href="index.php" target="_blank" title="Proximity Job Seeker">
        <img src="Proximity Job Seeker.png" height="500" width="2500" title="Proximity Job Seeker">
        </a>
        <h1 align="center" style="background-color: white;"><b> PROXIMITY JOB SEEKER </b></h1>
        <h2 align="center" style="color: white;"> Find Career Opportunities at Your Doorstep</h2>
        <hr style="background-color: white;">

        <h3 align="center" style="color: white;"><b>Log In</b></h3>
        
        <form align="center" action="index.php" method="POST" > 

            
            <label style="background-color: white;">Candidate</label>
            <input type="radio" name="user_type" value="candidate" required>
            <label style="background-color: white;">Employer</label>
            <input type="radio" name="user_type" value="employer" required>
            <br>
            <br>
            
             <label for="email" style="color: white;">Email:</label>
             <input type="email" id="email" name="email" required>
            

            <br>
            <br>
            
             <label for="password" style="color: white;">Password:</label>
             <input type="password"   id="password" name="password" required>
            
            <br>
            <br>

            
             <input type="submit" value="Log In" name="login">
           
        </form>
        <br>
        <hr style="background-color: white;">

        <a href="signup.php" target="_self" title="Proximity Job Seeker">
            <h3 align="center" style="color: white;"><b>Don't Have an Account? Sign Up</b></h3>
        </a>

        



    </body>







</html>