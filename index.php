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
            <h1>"GTU Students Ka Ultimate Study Point!"
</h1>
            <p>"Pad Le Betaa is your one-stop digital platform for all GTU study needs.<br> Whether you're struggling with MIMP questions or hunting for last-minute notes <br>– we’ve got you covered from Semester 1 to 7!"
.</p>
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
                <a href="http://t.me/padlebetaa"><img src="" alt=""></a>
                <a href="www.youtube.com/@Pad_Le_Betaa_Gtu">youtube</a>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>