<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAD LE BETAA GTU - Home</title>
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
        <section class="hero">
            <h1>"Simplified Study Material for Every GTU Semester!"

</h1> <div>
            <li>
                 What’s Inside:
            </li> 
              
<li> Unit-wise Handwritten Notes.</li>
<li> MIMP Questions (Most Important ).</li>
<li> PYQ (Previous Year Questions ).</li>
<li> Paper Solutions .</li>
<li> Book Pdf.</li>
<li> Practical Solutions.</li>
<li> Repeated Questions Chawise .</li>
<li> Smart Study PDF with Pad Le Betaa .</li>
<li> Free Video Sources.</li>
<li> And Many More .....</li> </div>

            <?php include 'dynamic_content.php'; ?>
            <button onclick="exploreSemesters()">Explore Semesters</button>
        </section>

        <section class="semesters">
            <h2>Select a Semester</h2>
            <div class="semester-list">
                <?php
                include 'database.php';
                $result = $conn->query("SELECT id, name FROM semesters");
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='semester'>" . htmlspecialchars($row['name']) . " - <a href='materials.php?semester_id=" . $row['id'] . "'>View Materials</a></div>";
                }
                $conn->close();
                ?>
            </div>
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