<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ST Event Management</title>
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
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="order.php" class="btn btn-outline"><i class="fa-solid fa-cart-shopping"></i> Place Order</a>
                <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary"
                    style="background: rgba(255,255,255,0.1); color: white; box-shadow: none; border: 1px solid var(--glass-border); pointer-events: none;"><i
                        class="fa-regular fa-user"></i> Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="auth-wrapper">
        <div class="auth-card glass-panel animate-in">
            <h1 class="auth-title">Login</h1>

            <form action="login_handler.php" method="POST">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="error-message" style="color: #ff4d4d; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="success-message" style="color: #00f2fe; margin-bottom: 15px; text-align: center; font-size: 0.9rem;">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group delay-1 animate-in">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required
                        autofocus>
                    <i class="fa-regular fa-envelope form-icon"></i>
                </div>

                <div class="form-group delay-2 animate-in">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                    <i class="fa-solid fa-lock form-icon"></i>
                </div>

                <button type="submit" class="btn btn-primary auth-btn delay-3 animate-in">Login</button>
                <a href="signup.php" class="btn btn-outline auth-btn auth-btn-secondary delay-4 animate-in">Sign Up</a>

                <div class="auth-links delay-5 animate-in">
                    <p>Don't have an account? <a href="signup.php">Create one here</a></p>
                </div>
            </form>
        </div>
    </main>

</body>

</html>