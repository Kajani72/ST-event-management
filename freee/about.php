<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | ST Event Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/about.css">
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
            <a href="about.php" class="btn btn-outline" style="border-color: var(--accent-primary);"><i
                    class="fa-regular fa-address-card"></i> About Us</a>
            <a href="order.php" class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i> Place Order</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="my_orders.php" class="btn btn-outline"><i class="fa-solid fa-list-check"></i> My Orders</a>
                <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">

        <div class="about-hero animate-in delay-1">
            <h1 class="about-title">About ST Event Management</h1>
            <p
                style="color: var(--text-secondary); max-width: 800px; margin: 0 auto; font-size: 1.1rem; line-height: 1.6;">
                We are a passionate team of event planners dedicated to turning your dreams into reality.
                With years of experience in the industry, we specialize in curating unforgettable moments,
                from large corporate events to intimate gatherings. Our commitment to excellence ensures that
                every detail is meticulously handled so you can enjoy your special day stress-free.
            </p>
        </div>

        <div class="info-grid">
            <div class="info-card animate-in delay-2">
                <i class="fa-solid fa-location-dot info-icon"></i>
                <h3 class="info-title">Address</h3>
                <p class="info-text">Jaffna ,Sri Lanka </p>
            </div>

            <div class="info-card animate-in delay-3">
                <i class="fa-solid fa-phone info-icon"></i>
                <h3 class="info-title">Phone Number</h3>
                <p class="info-text">077 4584251 <br>070 5856378 </p>
            </div>

            <div class="info-card animate-in delay-4">
                <i class="fa-solid fa-envelope info-icon"></i>
                <h3 class="info-title">Email</h3>
                <p class="info-text">stevent@gamil.com </p>
            </div>

            <div class="info-card animate-in delay-5">
                <i class="fa-solid fa-clock info-icon"></i>
                <h3 class="info-title">Business Hours</h3>
                <p class="info-text">Mon - Fri: 9:00 AM - 6:00 PM <br> Sat: 10:00 AM - 4:00 PM</p>
            </div>
        </div>

        <div class="contact-section animate-in delay-6">
            <h2 class="contact-title">Send us a Message</h2>
            <form action="contact_handler.php" method="POST">
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="error-message" style="color: #ff4d4d; margin-bottom: 20px; text-align: center;">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="success-message" style="color: #00f2fe; margin-bottom: 20px; text-align: center;">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required>
                    <i class="fa-regular fa-user form-icon"></i>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Your Email Address" required>
                    <i class="fa-regular fa-envelope form-icon"></i>
                </div>

                <div class="form-group">
                    <label for="contact-no">Contact NO</label>
                    <input type="tel" id="contact-no" name="contact_no" class="form-control" placeholder="Your Phone Number">
                    <i class="fa-solid fa-phone form-icon"></i>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" placeholder="How can we help you?"
                        style="min-height: 150px; resize: vertical;" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary auth-btn"
                    style="background: linear-gradient(135deg, var(--accent-secondary), var(--accent-primary)); border-radius: 30px;">
                    <i class="fa-regular fa-paper-plane"></i> Submit Message
                </button>
            </form>
        </div>

        <div style="text-align: left; margin-top: 20px;">
            <a href="index.php" class="btn btn-outline animate-in delay-6"><i class="fa-solid fa-chevron-left"></i>
                Back to Home</a>
        </div>

    </main>

</body>

</html>