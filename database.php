<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pad_le_beta_gtu";

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Create tables if they don't exist
$conn->query("
    CREATE TABLE IF NOT EXISTS semesters (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description TEXT,
        UNIQUE (name)
    )
");

$conn->query("
    CREATE TABLE IF NOT EXISTS materials (
        id INT AUTO_INCREMENT PRIMARY KEY,
        semester_id INT,
        title VARCHAR(255) NOT NULL,
        type VARCHAR(50) NOT NULL,
        url VARCHAR(255) NOT NULL,
        FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE CASCADE
    )
");

$conn->query("
    CREATE TABLE IF NOT EXISTS dynamic_content (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section VARCHAR(50) NOT NULL,
        content TEXT NOT NULL,
        UNIQUE (section)
    )
");

$conn->query("
    CREATE TABLE IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME NOT NULL
    )
");

$conn->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )
");

// Insert default semesters if not already present
$semesters = [
    "First Year (Sem 1 & 2)", "Semester 3", "Semester 4", 
    "Semester 5", "Semester 6", "Semester 7", "Semester 8"
];
$stmt = $conn->prepare("INSERT IGNORE INTO semesters (name) VALUES (?)");
foreach ($semesters as $sem) {
    $stmt->bind_param("s", $sem);
    $stmt->execute();
}
$stmt->close();
?>