<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAD LE BETAA GTU - Study Materials</title>
    <link rel="icon" type="image/png" sizes="64x64" href="logo2.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo2.png" alt="PAD LE BETAA GTU Logo" style="height: 60px; vertical-align: middle; margin-right: 10px;">
            PAD LE BETAA GTU
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="nav-menu">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="study_materials.php">Study Materials</a>
            <a href="contact.php">Contact</a>
            <a href="admin.php">Admin</a>
        </nav>
    </header>

    <main>
        <section class="resources">
            <h2>Materials for <?php
                include 'database.php';
                $semester_id = isset($_GET['semester_id']) ? (int)$_GET['semester_id'] : 0;
                $stmt = $conn->prepare("SELECT name FROM semesters WHERE id = ?");
                $stmt->bind_param("i", $semester_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $semester_name = $result->fetch_assoc()['name'] ?? "Unknown Semester";
                echo htmlspecialchars($semester_name);
                $stmt->close();
            ?></h2>
            <div class="resources">
                <?php
                $stmt = $conn->prepare("SELECT title, type, url FROM materials WHERE semester_id = ?");
                $stmt->bind_param("i", $semester_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='resource'><a href='" . htmlspecialchars($row['url']) . "' target='_blank'>" . htmlspecialchars($row['title']) . " (" . htmlspecialchars($row['type']) . ")</a></div>";
                    }
                } else {
                    echo "<p>No materials available for this semester.</p>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>© 2025 PAD LE BETAA GTU. All rights reserved.</p>
            <p>Empowering GTU students with high-quality academic resources.</p>
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