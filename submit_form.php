<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $job_role = $_POST['job_role'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    
    // File upload handling
    $cv_path = $_FILES['upload']['name'];
    $temp_file = $_FILES['upload']['tmp_name'];
    $uploads_dir = 'uploads/'; // Create a directory to store uploaded files
    $target_file = $uploads_dir . basename($cv_path);

    // Save data to SQLite database using prepared statements
    try {
        $db = new SQLite3('job_applications.db');
        $stmt = $db->prepare("INSERT INTO applications (first_name, last_name, email, job_role, address, city, pincode, cv_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $first_name);
        $stmt->bindParam(2, $last_name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $job_role);
        $stmt->bindParam(5, $address);
        $stmt->bindParam(6, $city);
        $stmt->bindParam(7, $pincode);
        $stmt->bindParam(8, $cv_path);
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Database Error: " . $e->getMessage());
        echo "Error: Application submission failed.";
        exit;
    }

    // Move uploaded file to destination directory
    if (move_uploaded_file($temp_file, $target_file)) {
        // Email handling
        $to = $email;
        $subject = "Job Application Submitted";
        // ... (rest of the email content)

        $headers = [
            "From: example@example.com",
            "Reply-To: example@example.com",
            "X-Mailer: PHP/" . phpversion(),
            "MIME-Version: 1.0",
            "Content-Type: text/plain; charset=UTF-8"
        ];
        $headers = implode("\r\n", $headers);

        // Send emails
        mail($to, $subject, $message, $headers);
        mail("your_email@example.com", $subject, $message, $headers);

        echo "Application submitted successfully!";
    } else {
        echo "Error: File upload failed.";
    }
} else {
    echo "Invalid request!";
}
?>
