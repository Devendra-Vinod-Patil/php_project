<?php
include 'database.php';
$stmt = $conn->prepare("SELECT content FROM dynamic_content WHERE section = ?");
$section = "hero";
$stmt->bind_param("s", $section);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo $row['content'];
} else {
    echo "<p>Welcome to PAD LE BETA GTU! Your one-stop platform for GTU study resources.</p>";
}
$stmt->close();
$conn->close();
?>