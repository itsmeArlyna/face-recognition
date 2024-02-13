<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registration";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $school_id = $_POST['school_id'];

    // Create a unique folder for each registration
    $registration_folder = "uploads/" . $school_id . "/";
    mkdir($registration_folder);

    // File upload handling
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];

    // Move uploaded files to the registration folder
    move_uploaded_file($_FILES['image1']['tmp_name'], $registration_folder . $image1);
    move_uploaded_file($_FILES['image2']['tmp_name'], $registration_folder . $image2);

    // Insert data into the database
    $sql = "INSERT INTO registration_data (name, school_id, registration_folder, image1, image2) 
            VALUES ('$name', '$school_id', '$registration_folder', '$image1', '$image2')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
