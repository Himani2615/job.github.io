<?php
// Separate file for database configuration (optional)
// include 'db_config.php';

try {
    // Create or connect to the SQLite database
    $db = new SQLite3('job_applications.db');

    // Define SQL query to create the 'applications' table
    $query = "CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT NOT NULL,
        job_role TEXT NOT NULL,
        address TEXT NOT NULL,
        city TEXT NOT NULL,
        pincode TEXT NOT NULL,
        cv_path TEXT NOT NULL
    );";

    // Execute the SQL query
    $db->exec($query);

    // Optionally, close the database connection (if not using persistent connection)
    // $db->close();

} catch (Exception $e) {
    // Log or display the error message
    error_log("Database Setup Error: " . $e->getMessage());
    echo "Error: Database setup failed. Please check the logs for more details.";
}
?>

