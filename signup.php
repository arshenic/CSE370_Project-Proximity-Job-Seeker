<?php
include "database.php";



if (isset($_POST['signup'])) {

    $user_type = $_POST['user_type'];
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $name = $first_name . " " . $last_name;

    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if($password != $confirm_password){
        echo "<h3 align='center' style='color: white;'>Passwords do not match!</h3>";
    }

    if ($user_type == "candidate") {

        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $nid = $_POST['NID'];
        $cgpa = $_POST['CGPA'];
        $background = $_POST['CurrentEd'];
        $area = $_POST['CArea'];

        $cv_name = "";

        if (!empty($_FILES['cv']['name'])) {

            
            $email_name = str_replace(['@', '.'], '_', $email);

           
            $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);

            
            $cv_name = $email_name . "." . $ext;

            
            move_uploaded_file($_FILES['cv']['tmp_name'], "CV/" . $cv_name);
        
        }

        $sql = "INSERT INTO Candidate 
        (Name, Phone, Email, Password, NID, DOB, CGPA, CurrentEdBackground, CV, Area, Gender)
        VALUES 
        ('$name', '$phone', '$email', '$password', '$nid', '$dob', '$cgpa', '$background', '$cv_name', '$area', '$gender')";

        if (mysqli_query($conn, $sql)) {
            echo "<h3 align='center' style='color: white;'>Candidate registered successfully!</h3>";
            header("Location: index.php");
            
        } 
        else {
            echo "<h3 align='center' style='color: white;'>Error: " . mysqli_error($conn) . "</h3>";
        }
        
        
        
        

    }

    else if ($user_type == "employer") {

        $housing = $_POST['Housing'];
        $street = $_POST['Street'];
        $city = $_POST['City'];
        $area = $_POST['EArea'];
        $postal_code = $_POST['PostalCode'];

        $sql = "INSERT INTO Employer
        (Name, Phone, Email, Password, Housing, Street, City, Area, PostalCode)
        VALUES
        ('$name', '$phone', '$email', '$password', '$housing', '$street', '$city', '$area', '$postal_code')";

        if (mysqli_query($conn, $sql)) {
            echo "<h3 align='center' style='color: white;'>Employer registered successfully!</h3>";
            header("Location: index.php");
        } 
        else {
            echo "<h3 align='center' style='color: white;'>Error: " . mysqli_error($conn) . "</h3>";
        }
        
        

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
        <title> Proximity Job Seeker: Sign Up </title>
    </head>

    <body style="background-color: black;">
        <h2 align="center" style="color: white;">Fill Out Required Information</h2>
        <hr style="background-color: white;">
        
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            
            <h4 style="color: white;">User Type:</h4>
            <label style="background-color: white;">Candidate</label>
            <input type="radio" name="user_type" value="candidate" required>
            <label style="background-color: white;">Employer</label>
            <input type="radio" name="user_type" value="employer" required>
            <br>


            <hr style="background-color: white;">

            <h3 style="color: white;">ONLY CANDIDATE INFORMATION</h3>
            
            <label for="dob" style="color: white;">Date of Birth:</label>
            <input type="date" id="dob" name="dob" >
           
            <h4 style="color: white;">Gender:</h4>
            <label style="background-color: white;">Male</label>
            <input type="radio" name="gender" value="male" >
            <label style="background-color: white;">Female</label>
            <input type="radio" name="gender" value="female" >
            <br>
            <br>

            <label for="NID" style="color: white;">National ID:</label>
            <input type="text" id="NID" name="NID"  placeholder="NID000">
            <br>
            <br>

            <label for="CurrentEd" style="color: white;">CurrentEdBackground:</label>
            <input type="text" id="CurrentEd" name="CurrentEd"  placeholder="BSc in CSE">
            
            <label for="CGPA" style="color: white;">CGPA:</label>
            <input type="float(3,2)" id="CGPA" name="CGPA"  placeholder="0.00">
            <br>
            <br>

            <label for="CArea" style="color: white;">Area:</label>
            <input type="text" id="CArea" name="CArea"  placeholder="Gulshan">
            <br>
            <br>

            <label for="CV" style="color: white;">CV:</label>
            <input type="file" id="CV" name="cv" accept=".pdf,.doc,.docx" >
            <br>
            <br>
            <br>

            <hr style="background-color: white;">

            <h3 style="color: white;">ONLY EMPLOYERS INFORMATION</h3>
            <label for="Housing" style="color: white;">Housing:</label>
            <input type="text" id="Housing" name="Housing"  placeholder="52">
            
            <label for="Street" style="color: white;">Street:</label>
            <input type="text" id="Street" name="Street"  placeholder="02">
            
            <label for="EArea" style="color: white;">Area:</label>
            <input type="text" id="EArea" name="EArea"  placeholder="Gulshan">
            <br>
            <br>

            <label for="City" style="color: white;">City:</label>
            <input type="text" id="City" name="City"  placeholder="Dhaka">
            
            <label for="PostalCode" style="color: white;">PostalCode:</label>
            <input type="text" id="PostalCode" name="PostalCode" placeholder="1100">
            <br>
            <br>
            <br>

            <hr style="background-color: white;">

            <h3 style="color: white;">COMMON PERSONAL INFORMATION FOR ALL USERS</h3>
            
            <label for="fname" style="color: white;">First Name:</label>
            <input type="text" id="fname" name="fname" required placeholder="John">
           
            <label for="lname" style="color: white;">Last Name:</label>
            <input type="text" id="lname" name="lname"  placeholder="Doe">
            <br>
            <br>

            <label for="phone" style="color: white;">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required placeholder="01234567890" maxlength="11">
            <br>
            <br>

            <label for="email" style="color: white;">Email:</label>
            <input type="email" id="email" name="email" required placeholder="john.doe@email.com">
            <br>
            <br>

            <label for="password" style="color: white;">Password:</label>
            <input type="password" id="password" name="password" required placeholder="********">
            <br>
            <br>

            <label for="confirm_password" style="color: white;">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required placeholder="********">
            <br>
            <br>
            <br>

            <input type="reset" value="Reset">

            <input type="submit" value="Sign Up" name="signup">
            
            <a href="index.php" target="_self" title="Proximity Job Seeker">
                <h4 style="color: white;">Return to Login</h4>
            </a>


            

        </form>

    </body>

</html>