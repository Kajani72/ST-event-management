<?php 
session_start(); 
if(!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to place an order.";
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order | ST Event Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css"> <!-- Reusing form styles -->
    <link rel="stylesheet" href="css/event.css">
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
            <a href="about.php" class="btn btn-outline"><i class="fa-regular fa-address-card"></i> About Us</a>
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-house"></i> Home</a>
            <a href="my_orders.php" class="btn btn-outline"><i class="fa-solid fa-list-check"></i> My Orders</a>
            <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </header>

    <main class="container">
        <div class="order-container">
            <div class="glass-panel order-card animate-in delay-1">
                <div style="text-align: center; margin-bottom: 40px;">
                    <h1 class="auth-title" style="margin-bottom: 10px;">Place Your Order</h1>
                    <p style="color: var(--text-secondary);">Fill in the details below and we'll start planning your
                        dream event.</p>
                </div>

                <form action="order_handler.php" method="POST" enctype="multipart/form-data">
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
                    <div class="form-grid">
                        <!-- Left side inputs -->
                        <div class="left-inputs">
                            <div class="form-group">
                                <label for="event-type">Event Type</label>
                                <select id="event-type" name="event_type" class="form-control" required>
                                    <option value="" disabled selected>Select an event type</option>

                                    <option value="birthday">Birthday Party</option>
                                    <option value="babyshower">Baby Shower</option>
                                    <option value="marquee">Marquee Setup</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="event-date">Event Date</label>
                                <input type="date" id="event-date" name="event_date" class="form-control" required
                                    style="color-scheme: dark;">
                            </div>

                            <div class="form-group">
                                <label for="contact-no">Contact NO</label>
                                <input type="tel" id="contact-no" name="contact_no" class="form-control" placeholder="+94 77 000 0000"
                                    required>
                                <i class="fa-solid fa-phone form-icon" style="top: 38px;"></i>
                            </div>

                            <div class="form-group">
                                <label for="location">Location / Venue</label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="Enter venue address"
                                    required>
                                <i class="fa-solid fa-location-dot form-icon" style="top: 38px;"></i>
                            </div>
                        </div>

                        <!-- Right side inputs -->
                        <div class="right-inputs">
                            <div class="form-group">
                                <label>Reference Images</label>
                                <div class="upload-area" onclick="document.getElementById('file-upload').click()">
                                    <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                                    <span>Add sample images here</span>
                                    <span style="font-size: 0.8rem; margin-top: 5px; color: var(--text-secondary);">Drag
                                        & drop or click to browse</span>
                                    <input type="file" id="file-upload" name="reference_images[]" style="display: none;" multiple>
                                </div>
                            </div>

                            <div class="form-group" style="height: calc(100% - 170px);">
                                <label for="description">Description & Special Requests</label>
                                <textarea id="description" name="description" class="form-control"
                                    placeholder="Tell us more about your vision..."
                                    style="height: 50%; min-height: 100px; resize: none;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 40px; text-align: center;">
                        <button type="submit" class="btn btn-primary"
                            style="padding: 15px 40px; font-size: 1.1rem; border-radius: 30px; letter-spacing: 1px;">
                            <i class="fa-regular fa-calendar-check"></i> Book Your Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Simple file upload interaction
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('file-upload');

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('active');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('active');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('active');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                uploadArea.innerHTML = `<i class="fa-solid fa-check-circle upload-icon" style="color: #00f2fe;"></i><span>${e.dataTransfer.files.length} file(s) selected</span>`;
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                uploadArea.innerHTML = `<i class="fa-solid fa-check-circle upload-icon" style="color: #00f2fe;"></i><span>${fileInput.files.length} file(s) selected</span>`;
            }
        });
    </script>
</body>

</html>