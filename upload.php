<?php
// MySQL database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "checklist_cartech";

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a PDF file was uploaded
if (isset($_FILES['pdfFile'])) {
    $pdfFile = $_FILES['pdfFile'];

    // Check for errors during the file upload
    if ($pdfFile['error'] === UPLOAD_ERR_OK) {
        $pdfName = $pdfFile['name'];
        $pdfTmpName = $pdfFile['tmp_name'];

        // Read the PDF file content
        $pdfContent = file_get_contents($pdfTmpName);

        // Prepare the SQL statement
        $sql = "INSERT INTO pdf_files (name, content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $pdfName, $pdfContent);

        // Execute the SQL statement
        if ($stmt->execute() === TRUE) {
            echo "PDF file uploaded and stored in the database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error uploading the PDF file.";
    }
}

// Close the database connection
$conn->close();
?>
 