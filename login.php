<?php

session_start();

include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify(
            $password,
            $user["password"]
        )) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "Incorrect password.";

        }

    } else {

        $message = "Account not found.";

    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | NovaTech</title>

    <link rel="stylesheet" href="style.css">

</head>

<body class="auth-page">

<div class="auth-container">

    <div class="auth-info">

        <div class="logo">
            Nova<span>Tech</span>
        </div>

        <h1>Welcome back.</h1>

        <p>
            Login to access your NovaTech dashboard
            and company information.
        </p>

        <div class="auth-feature">
            🔐 Secure Login
        </div>

        <div class="auth-feature">
            📊 Personalized Dashboard
        </div>

        <div class="auth-feature">
            ⚡ Easy Access
        </div>

    </div>


    <div class="form-container">

        <h2>Welcome Back!</h2>

        <p class="form-subtitle">
            Login to your account
        </p>


        <?php if ($message != "") { ?>

            <div class="error">
                <?php echo $message; ?>
            </div>

        <?php } ?>


        <form method="POST">

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >


            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >


            <button type="submit" class="form-btn">
                Login
            </button>

        </form>


        <p class="bottom-text">

            Don't have an account?

            <a href="register.php">
                Create Account
            </a>

        </p>

    </div>

</div>

</body>
</html>