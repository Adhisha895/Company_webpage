<?php

include "db.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Check that all fields are filled
    if ($name == "" || $email == "" || $password == "" || $role == "") {

        $message = "Please fill all the fields.";
        $message_type = "error";

    } else {

        // Check whether email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";

        $check = mysqli_prepare($conn, $check_sql);

        if ($check === false) {
            die("CHECK QUERY ERROR: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($check, "s", $email);

        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {

            $message = "This email is already registered.";
            $message_type = "error";

        } else {

            // Encrypt the password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert the new user
            $sql = "INSERT INTO users (name, email, password, role)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            // Check whether INSERT query was prepared successfully
            if ($stmt === false) {
                die("INSERT QUERY ERROR: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $name,
                $email,
                $hashed_password,
                $role
            );

            // Execute INSERT query
            if (mysqli_stmt_execute($stmt)) {

                $message = "Registration successful!";
                $message_type = "success";

            } else {

                $message = "Registration failed: " .
                           mysqli_stmt_error($stmt);

                $message_type = "error";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register | NovaTech</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="auth-page">

<div class="auth-container">

    <!-- LEFT SIDE -->

    <div class="auth-info">

        <div class="logo">
            Nova<span>Tech</span>
        </div>

        <h1>Join our team.</h1>

        <p>
            Create your account and become part of
            the NovaTech community.
        </p>

        <div class="auth-feature">
            ✓ Modern workplace
        </div>

        <div class="auth-feature">
            ✓ Innovative projects
        </div>

        <div class="auth-feature">
            ✓ Professional growth
        </div>

    </div>


    <!-- RIGHT SIDE -->

    <div class="form-container">

        <h2>Create Account</h2>

        <p class="form-subtitle">
            Enter your details to register
        </p>


        <!-- DISPLAY MESSAGE -->

        <?php

        if ($message != "") {

            echo '<div class="' . $message_type . '">';
            echo htmlspecialchars($message);
            echo '</div>';

        }

        ?>


        <!-- REGISTRATION FORM -->

        <form method="POST"
              onsubmit="return validateRegister()">

            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your full name"
                required
            >


            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >


            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
                required
            >


            <label for="role">
                Select Role
            </label>

            <select
                id="role"
                name="role"
                required
            >

                <option value="">
                    Select your role
                </option>

                <option value="admin">
                    Admin
                </option>

                <option value="employee">
                    Employee
                </option>

            </select>


            <button
                type="submit"
                class="form-btn"
            >
                Create Account
            </button>

        </form>


        <p class="bottom-text">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </p>

    </div>

</div>


<script src="script.js"></script>

</body>

</html>