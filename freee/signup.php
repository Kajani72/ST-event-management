<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | ST Event Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <header>
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-glass-cheers"></i>
            </div>
            ST Event Management
        </a>
        <nav class="nav-links">
            <a href="login.php" class="btn btn-outline"><i class="fa-regular fa-user"></i> Login</a>
        </nav>
    </header>

    <main class="auth-wrapper">
        <div class="auth-card glass-panel animate-in">
            <h1 class="auth-title">Create Account</h1>

            <form action="signup_handler.php" method="POST">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="error-message" style="color: #ff4d4d; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group delay-1 animate-in">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" required autofocus>
                    <i class="fa-regular fa-user form-icon"></i>
                </div>

                <div class="form-group delay-2 animate-in">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
                    <i class="fa-regular fa-envelope form-icon"></i>
                </div>

                <div class="form-group delay-3 animate-in">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                    <i class="fa-solid fa-lock form-icon"></i>
                </div>

                <div class="form-group delay-4 animate-in">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Repeat your password"
                        required>
                    <i class="fa-solid fa-shield-halved form-icon"></i>
                </div>

                <button type="submit" class="btn btn-primary auth-btn delay-5 animate-in"
                    style="background: linear-gradient(135deg, var(--accent-pink), var(--accent-orange)); color: rgb(10, 10, 10); box-shadow: 0 4px 15px rgba(255, 8, 68, 0.3);">Sign
                    Up</button>

                <div class="auth-links delay-6 animate-in">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </main>

</body>

</html>