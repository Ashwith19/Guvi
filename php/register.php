<?php
$mysqli = new mysqli("localhost", "root", "", "guvi");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["fullname"];
    $email = $_POST["mail"];
    $password = $_POST["passkey"];
    $PhoneNumber = $_POST["contact"];
    $BirthDate = $_POST["DOB"];
    $Gender = $_POST["Gender"];
    $CurrentLocation = $_POST["Current"];
    

    // checking wheather email is available or not
    $query = "SELECT email FROM users WHERE email= ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get the number of rows fetched
    $numRows = $result->num_rows;

    // Validate the user credentials against the database
    if ($numRows > 0) {
        echo "<script>
            alert('user is already available!');
            window.location.href = '../index.html';
        </script>";
    }
    else{
    $stmt = $mysqli->prepare("INSERT INTO ashus(username, password, Email, PhoneNumber, BirthDate, Gender, CurrentLocation ) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $password, $email, $PhoneNumber, $BirthDate, $Gender, $CurrentLocation);

    if ($stmt->execute()) {
        // echo "Registration successful!";
        header('Location:../login.html');
        exit();
        // echo"<script>document.location='../login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
}


$mysqli->close();
?>
