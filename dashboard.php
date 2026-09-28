<?php

session_start();

include "db.php";

// Check whether user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION["name"];
$role = $_SESSION["role"];

// Get all registered users
$sql = "SELECT id, name, email, role FROM users ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard | NovaTech</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="dashboard-page">


<!-- =========================
     NAVIGATION BAR
========================= -->

<header class="navbar">

    <div class="logo">
        Nova<span>Tech</span>
    </div>

    <button class="menu-btn" onclick="toggleMenu()">☰</button>

    <nav id="navMenu">

        <a href="index.php">Home</a>

        <a href="index.php#about">About</a>

        <a href="index.php#services">Services</a>

        <a href="dashboard.php" class="active">
            Dashboard
        </a>

        <a href="logout.php" class="nav-login">
            Logout
        </a>

    </nav>

</header>


<!-- =========================
     DASHBOARD
========================= -->

<main class="dashboard-container">


    <!-- WELCOME SECTION -->

    <section class="dashboard-welcome">

        <p class="section-label">
            DASHBOARD
        </p>

        <h1>
            Welcome, <?php echo htmlspecialchars($name); ?> 👋
        </h1>

        <p>
            You are logged in as
            <strong><?php echo htmlspecialchars($role); ?></strong>.
        </p>

    </section>


    <!-- =========================
         DASHBOARD CARDS
    ========================= -->

    <section class="dashboard-cards">

        <div class="dashboard-card">

            <div class="dashboard-icon">
                👤
            </div>

            <div>
                <h3>
                    Logged-in User
                </h3>

                <p>
                    <?php echo htmlspecialchars($name); ?>
                </p>
            </div>

        </div>


        <div class="dashboard-card">

            <div class="dashboard-icon">
                🔐
            </div>

            <div>
                <h3>
                    Role
                </h3>

                <p>
                    <?php echo htmlspecialchars($role); ?>
                </p>
            </div>

        </div>


        <div class="dashboard-card">

            <div class="dashboard-icon">
                👥
            </div>

            <div>
                <h3>
                    Employees
                </h3>

                <p>
                    Registered users
                </p>
            </div>

        </div>

    </section>


    <!-- =========================
         EMPLOYEE TABLE
    ========================= -->

    <section class="table-container">

        <div class="table-heading">

            <div>

                <p class="section-label">
                    COMPANY USERS
                </p>

                <h2>
                    Employee Details
                </h2>

                <p>
                    Here are the registered users in the company.
                </p>

            </div>

            <a href="register.php" class="btn primary">
                + Add Employee
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Role</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row["id"]); ?>
                        </td>

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($row["name"]); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["email"]); ?>
                        </td>

                        <td>

                            <span class="role-badge">

                                <?php
                                echo htmlspecialchars(
                                    ucfirst($row["role"])
                                );
                                ?>

                            </span>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="4" class="no-data">

                            No users found.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </section>


    <!-- BACK HOME BUTTON -->

    <div class="dashboard-actions">

        <a href="index.php" class="btn secondary">
            ← Back to Home
        </a>

        <a href="logout.php" class="btn primary">
            Logout
        </a>

    </div>


</main>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <div class="footer-logo">
        Nova<span>Tech</span>
    </div>

    <p>
        © 2026 NovaTech. All Rights Reserved.
    </p>

    <div class="footer-links">

        <a href="index.php">
            Home
        </a>

        <a href="index.php#about">
            About
        </a>

        <a href="index.php#services">
            Services
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</footer>


<script src="script.js"></script>

</body>

</html>