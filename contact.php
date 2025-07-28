<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAD LE BETA GTU -contacts </title>
     <link rel="icon" type="image/png" sizes="64*64" href="logo3.png" >
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
            <div class="logo">
            <img src="logo2.png" alt="logo.png" style="height: 65px; vertical-align: middle; margin-right: 5px;">PAD LE BETAA GTU</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="study_materials.php">Study Materials</a>
            <a href="contact.php">Contact</a>
            <a href="admin.php">Admin</a>
        </nav>
    </header>

    <main>
        <section class="contact">
            <h2>Contact Us</h2>
            <p>We’re here to assist you. Please fill out the form below to get in touch.</p>
            <?php
            include 'database.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $message = trim($_POST['message'] ?? '');

                if (empty($name) || empty($email) || empty($message)) {
                    echo "<p style='color: #FF4500;'>Please fill out all fields.</p>";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<p style='color: #FF4500;'>Please enter a valid email address.</p>";
                } else {
                    $sql = "INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $name, $email, $message);
                    if ($stmt->execute()) {
                        header("Location: contact.php?success=1");
                        exit();
                    } else {
                        echo "<p style='color: #FF4500;'>Error: Could not submit your message.</p>";
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
            <form id="contactForm" action="contact.php" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea ASSIGNMENT_1 name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Submit</button>
            </form>
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<p style='color: #4682B4;'>Thank you for your message!</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>© 2025 PAD LE BETA GTU. All rights reserved.</p>
            <p>Designed to empower GTU students with quality resources.</p>
            <div class="footer-links">
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <a href="study_materials.php">Study Materials</a>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>