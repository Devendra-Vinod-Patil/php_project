<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAD LE BETAA GTU - Home</title>
    <link rel="icon" type="image/png" sizes="64x64" href="logo3.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #C71585; /* Royal pink */
            height: 60px;
            color: #FFF; /* White for contrast */
        }

        .logo img {
            height: 100px;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: #FFF; /* White for contrast */
            transition: all 0.3s ease;
        }

        .nav-menu {
            display: flex;
            gap: 10px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #FFF;
            font-weight: 500;
            padding: 8px 16px;
            background-color: #DB4C9B; /* Lighter pink for buttons */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-menu a:hover {
            background-color: #EC82B1; /* Even lighter pink on hover */
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background-color: #C71585; /* Royal pink */
                padding: 20px;
                text-align: center;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-menu a {
                margin: 5px 0;
            }
        }

        .hero {
            text-align: center;
            padding: 40px 20px;
            background-color: #FFF8E1; /* Light cream */
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #4A2F00; /* Dark brown */
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: #333;
        }

        .hero button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #D4A017; /* Golden brown */
            color: #FFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .hero button:hover {
            background-color: #E6B800; /* Brighter gold */
        }

        .semesters {
            padding: 40px 20px;
            text-align: center;
            background-color: #FFF;
        }

        .semesters h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #4A2F00; /* Dark brown */
        }

        .semester-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .semester {
            background-color: #FFF8E1; /* Light cream */
            padding: 20px;
            border-radius: 5px;
            width: 200px;
        }

        .semester a {
            text-decoration: none;
            color: #D4A017; /* Golden brown */
        }

        .semester a:hover {
            text-decoration: underline;
            color: #E6B800; /* Brighter gold */
        }

        footer {
            background-color: #4A2F00; /* Dark brown */
            color: #FFFDD0; /* Royal cream */
            text-align: center;
            padding: 20px;
        }

        .footer-content p {
            margin: 5px 0;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            color: #FFF8E1; /* Light cream */
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
            color: #FFFDD0; /* Royal cream */
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo2.png" alt="logo.png" style="height: 100px; vertical-align: middle; margin-right: 8px;">PAD LE BETAA GTU
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
        <section class="hero">
            <h1>"GTU Students Ka Ultimate Study Point!"</h1>
            <p>"Pad Le Betaa is your one-stop digital platform for all GTU study needs. Whether you're struggling with MIMP questions or hunting for last-minute notes – we’ve got you covered from Semester 1 to 7!"</p>
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

    <script>
        function toggleMenu() {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.classList.toggle('active');
        }

        function exploreSemesters() {
            document.querySelector('.semesters').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>