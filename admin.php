<?php
session_start();
include 'database.php';

// Check if a user already exists
$stmt = $conn->prepare("SELECT COUNT(*) as user_count FROM users");
$stmt->execute();
$result = $stmt->get_result();
$user_count = $result->fetch_assoc()['user_count'];
$stmt->close();

// Handle user registration (one-time)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register']) && $user_count == 0) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $register_error = "Please fill out all fields.";
    } elseif (strlen($username) < 4 || strlen($password) < 6) {
        $register_error = "Username must be at least 4 characters and password at least 6 characters.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password_hash);
        if ($stmt->execute()) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin.php");
            exit();
        } else {
            $register_error = "Error creating user. Please try again.";
        }
        $stmt->close();
    }
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && $user_count > 0) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin.php");
            exit();
        } else {
            $login_error = "Invalid username or password.";
        }
    } else {
        $login_error = "Invalid username or password.";
    }
    $stmt->close();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Handle adding materials
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_material']) && isset($_SESSION['admin_logged_in'])) {
    $semester_id = (int)($_POST['semester_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $url = trim($_POST['url'] ?? '');
    if ($semester_id && $title && $type && $url && filter_var($url, FILTER_VALIDATE_URL)) {
        $stmt = $conn->prepare("INSERT INTO materials (semester_id, title, type, url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $semester_id, $title, $type, $url);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php?success=1");
        exit();
    } else {
        $error = "Please fill out all fields correctly.";
    }
}

// Handle updating content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_content']) && isset($_SESSION['admin_logged_in'])) {
    $section = trim($_POST['section'] ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($section && $content) {
        $stmt = $conn->prepare("INSERT INTO dynamic_content (section, content) VALUES (?, ?) ON DUPLICATE KEY UPDATE content = ?");
        $stmt->bind_param("sss", $section, $content, $content);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php?success=2");
        exit();
    } else {
        $error = "Please provide valid content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAD LE BETAA GTU - Admin</title>
    <link rel="icon" type="image/png" sizes="64x64" href="logo2.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo2.png" alt="PAD LE BETAA GTU Logo" style="height: 60px; vertical-align: middle; margin-right: 10px;">
            PAD LE BETAA GTU - Admin
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
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <a href="admin.php?logout=1">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section class="admin">
            <h2>Admin Panel</h2>
            <?php if (!isset($_SESSION['admin_logged_in'])): ?>
                <?php if ($user_count == 0): ?>
                    <h3>Create Admin Account</h3>
                    <?php if (isset($register_error)): ?>
                        <p class="error"><?php echo htmlspecialchars($register_error); ?></p>
                    <?php endif; ?>
                    <form action="admin.php" method="POST">
                        <input type="text" name="username" placeholder="Choose Username" required>
                        <input type="password" name="password" placeholder="Choose Password" required>
                        <button type="submit" name="register">Create Account</button>
                    </form>
                <?php else: ?>
                    <h3>Login to Admin Panel</h3>
                    <?php if (isset($login_error)): ?>
                        <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
                    <?php endif; ?>
                    <form action="admin.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="login">Login</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <p style="color: #4682B4;">Action successful!</p>
                <?php endif; ?>
                <h3>Add Study Material</h3>
                <form action="admin.php" method="POST">
                    <select name="semester_id" required>
                        <option value="">Select Semester</option>
                        <?php
                        $result = $conn->query("SELECT id, name FROM semesters");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="title" placeholder="Material Title" required>
                    <input type="text" name="type" placeholder="Material Type (e.g., Notes, Paper)" required>
                    <input type="url" name="url" placeholder="Material URL" required>
                    <button type="submit" name="add_material">Add Material</button>
                </form>

                <h3>Update Hero Content</h3>
                <form action="admin.php" method="POST">
                    <input type="hidden" name="section" value="hero">
                    <textarea name="content" placeholder="Hero Section Content" required><?php
                        $stmt = $conn->prepare("SELECT content FROM dynamic_content WHERE section = ?");
                        $section = "hero";
                        $stmt->bind_param("s", $section);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()) {
                            echo htmlspecialchars($row['content']);
                        } else {
                            echo "Welcome to PAD LE BETAA GTU! Your one-stop platform for GTU study resources.";
                        }
                        $stmt->close();
                        $conn->close();
                    ?></textarea>
                    <button type="submit" name="update_content">Update Content</button>
                </form>
            <?php endif; ?>
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