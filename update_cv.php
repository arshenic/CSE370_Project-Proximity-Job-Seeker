<?php
session_start();
include "database.php";

if (!isset($_SESSION['candidate_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['upload_cv'])) {

    $candidate_id = $_SESSION['candidate_id'];

    // File info
    $file_name = $_FILES['new_cv']['name'];
    $file_tmp = $_FILES['new_cv']['tmp_name'];
    $file_size = $_FILES['new_cv']['size'];

    // File extension check
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = array("pdf", "doc", "docx");

    if (!in_array($file_ext, $allowed)) {
        echo "Only PDF, DOC, DOCX allowed!";
        exit();
    }

    
    $new_name = "cv_" . $candidate_id . "_" . time() . "." . $file_ext;
    $upload_path = "CV/" . $new_name;

    
    if (move_uploaded_file($file_tmp, $upload_path)) {

        
        $old_query = "SELECT CV FROM Candidate WHERE CandidateID='$candidate_id'";
        $old_result = mysqli_query($conn, $old_query);
        $old_row = mysqli_fetch_assoc($old_result);

        if ($old_row && file_exists("CV/" . $old_row['CV'])) {
            unlink("CV/" . $old_row['CV']);
        }


        $update = "UPDATE Candidate SET CV='$new_name' WHERE CandidateID='$candidate_id'";

        if (mysqli_query($conn, $update)) {
            echo "CV updated successfully!";
            header("refresh:1; url=candidate_dashboard.php");
        } else {
            echo "Database error!";
        }

    } else {
        echo "File upload failed!";
    }
}
?>