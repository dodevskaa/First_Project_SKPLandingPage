<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Поврзување со базата на податоци
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "aboutuspage";  

// Креирање на конекција
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка дали има грешка при конектирање
if ($conn->connect_error) {
    die("Не може да се поврзе со базата: " . $conn->connect_error);
}

// Проверка дали формата е испратена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Земаме податоци од формата и ги зачувуваме безбедно
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $company = $_POST['company'];

    // SQL за вметнување податоци (prepared statement)
    $sql = "INSERT INTO form_table (name, surname, phone, email, company) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $surname, $phone, $email, $company);

    // Извршување на query
    if ($stmt->execute()) {
        header("Location: thank_you.html"); 
        exit();
    } else {
        echo "Грешка: " . $stmt->error;
    }

    // Затворање на statement и конекција
    $stmt->close();
    $conn->close();
}
?>
