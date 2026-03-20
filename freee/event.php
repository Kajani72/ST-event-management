<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details | ST Event Management</title>

    <link rel="stylesheet" href="css/style.css">
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
            <a href="about.php" class="btn btn-outline">
                <i class="fa-regular fa-address-card"></i> About Us
            </a>

            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="my_orders.php" class="btn btn-outline"><i class="fa-solid fa-list-check"></i> My Orders</a>
            <?php endif; ?>

            <a href="order.php" class="btn btn-primary">
                <i class="fa-solid fa-cart-shopping"></i> Place Order
            </a>
        </nav>

    </header>


    <main class="container">

        <!-- Hero Section -->

        <div class="event-hero animate-in">
            <div class="event-hero-content">
                <h1 class="event-hero-title">Grand Wedding Setup</h1>

                <p style="font-size:1.2rem;color:#ddd;max-width:600px;margin:0 auto;">
                    Transform your special day into a magical experience.
                </p>

            </div>
        </div>


        <div class="event-details-layout">

            <!-- Left Column -->

            <div class="left-col animate-in delay-1">

                <div class="detail-section glass-panel detail-card">

                    <h2>
                        <i class="fa-solid fa-circle-info"></i> Event Description
                    </h2>

                    <p class="card-details" style="font-size:1.05rem;margin-bottom:20px;">
                    </p>

                    <p class="card-details" style="font-size:1.05rem;">
                    </p>


                    <!-- SAMPLE IMAGES GRID -->

                    <div class="sample-images-grid"
                        style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:30px;">

                        <div class="glass-panel"
                            style="width:100%;height:250px;border-radius:15px;overflow:hidden;border:1px solid var(--glass-border);">

                            <img id="sampleImg1" src="" style="width:100%;height:100%;object-fit:cover;">

                        </div>


                        <div class="glass-panel"
                            style="width:100%;height:250px;border-radius:15px;overflow:hidden;border:1px solid var(--glass-border);">

                            <img id="sampleImg2" src="" style="width:100%;height:100%;object-fit:cover;">

                        </div>

                    </div>

                </div>

            </div>


            <!-- Right Column -->

            <div class="right-col animate-in delay-2">

                <div class="glass-panel detail-card" style="position:sticky;top:100px;">

                    <h3>
                        <i class="fa-solid fa-box-open"></i> Available Packages
                    </h3>


                    <div class="package-item">

                        <h4 style="color:white;font-size:1.1rem;">
                            Basic Package
                        </h4>

                        <p class="card-details" style="margin-bottom:10px;margin-top:10px;">
                        </p>

                        <ul style="color:var(--text-secondary);font-size:0.85rem;padding-left:15px;margin-bottom:15px;">
                            <li>Up to 100 guests</li>
                            <li>Standard chairs</li>
                        </ul>

                        <div class="package-price"></div>

                        <a href="order.php" class="btn btn-outline" style="width:100%;margin-top:15px;">
                            Select
                        </a>

                    </div>


                    <div class="package-item"
                        style="border-color:var(--accent-primary);box-shadow:0 0 20px rgba(0,242,254,0.1);">

                        <div
                            style="background:var(--accent-primary);color:#000;font-size:0.7rem;font-weight:bold;padding:3px 10px;border-radius:10px;display:inline-block;margin-bottom:10px;">
                            POPULAR
                        </div>

                        <h4 style="color:white;font-size:1.1rem;">
                            Premium Package
                        </h4>

                        <p class="card-details" style="margin-bottom:10px;margin-top:10px;">
                        </p>

                        <div class="package-price"></div>

                        <a href="order.php" class="btn btn-primary" style="width:100%;margin-top:15px;">
                            Select
                        </a>

                    </div>

                </div>

            </div>

        </div>


        <a href="index.php" class="btn btn-outline back-btn animate-in delay-3">
            <i class="fa-solid fa-chevron-left"></i>
            Back to Events
        </a>

    </main>


    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category') || 'marquee';

        const contentData = {

            marquee: {
                title: "Marquee Event Setup",
                subtitle: "Create a stunning outdoor experience for your event.",
                desc1: "Our Marquee Setup provides a beautiful and spacious environment tailored to your gathering.",
                desc2: "This package includes high-quality canopy options and elegant lighting.",
                basicPrice: "7000",
                premiumPrice: "9000",
                basicDesc: "Standard marquee tent, basic lighting, seating for 50 guests.",
                premiumDesc: "Premium transparent marquee, fairy lighting, flooring and seating for 150 guests.",
                img1: "./images/marque 4.jpeg",
                img2: "./images/marque 5.jpeg"
            },

            birthday: {
                title: "Birthday Party Setup",
                subtitle: "Make your birthday an unforgettable celebration.",
                desc1: "Our Birthday Party Setup is customized to your theme and preferences.",
                desc2: "This package features themed decor, balloon arches and custom backdrops.",
                basicPrice: "15000",
                premiumPrice: "30000",
                basicDesc: "Simple balloon decor and cake table setup.",
                premiumDesc: "Full themed decor with photo booth and lighting.",
                img1: "./images/birthday 4.jpeg",
                img2: "./images/birthday 5.jpeg"
            },

            babyshower: {
                title: "Baby Shower Setup",
                subtitle: "Celebrate the arrival of your little one in style.",
                desc1: "Our Baby Shower Setup brings joy and elegance to your celebration.",
                desc2: "We provide floral decorations, seating and personalized sign boards.",
                basicPrice: "20000",
                premiumPrice: "30000",
                basicDesc: "Themed balloons and seating.",
                premiumDesc: "Full baby shower decor with backdrop.",
                img1: "./images/baby shower 5.jpeg",
                img2: "./images/baby shower 4.jpeg"
            }

        };

        const data = contentData[category] || contentData.marquee;

        const imgParam = urlParams.get('img');


        /* TITLE */

        const titleEl = document.querySelector('.event-hero-title');
        const subtitleEl = document.querySelector('.event-hero-content p');
        const heroEl = document.querySelector('.event-hero');

        if (titleEl) titleEl.textContent = data.title;
        if (subtitleEl) subtitleEl.textContent = data.subtitle;


        /* HERO IMAGE (UNCHANGED FROM YOUR ORIGINAL CODE) */

        if (heroEl && imgParam) {

            const heroImg = new Image();

            heroImg.onload = function () {

                heroEl.style.backgroundImage =
                    `linear-gradient(135deg, rgba(31,39,70,0.4) 0%, rgba(45,56,97,0.4) 100%), url('${imgParam}')`;

            };

            heroImg.src = imgParam;

        }


        /* DESCRIPTION */

        const descParagraphs = document.querySelectorAll('.detail-card p.card-details');

        if (descParagraphs.length >= 2) {

            descParagraphs[0].textContent = data.desc1;
            descParagraphs[1].textContent = data.desc2;

        }


        /* PRICES */

        const packagePrices = document.querySelectorAll('.package-price');

        if (packagePrices.length >= 2) {

            packagePrices[0].textContent = data.basicPrice;
            packagePrices[1].textContent = data.premiumPrice;

        }


        /* PACKAGE TEXT */

        const packageDescs = document.querySelectorAll('.package-item p.card-details');

        if (packageDescs.length >= 2) {

            packageDescs[0].textContent = data.basicDesc;
            packageDescs[1].textContent = data.premiumDesc;

        }


        /* SAMPLE IMAGES (NEW PART) */

        const sample1 = document.getElementById("sampleImg1");
        const sample2 = document.getElementById("sampleImg2");

        if (sample1 && sample2) {

            sample1.src = data.img1;
            sample2.src = data.img2;

        }


        /* ORDER LINKS */

        const basicLink = document.querySelector('.package-item .btn-outline[href*="order.php"]');
        const premiumLink = document.querySelector('.package-item .btn-primary[href*="order.php"]');

        if (basicLink) basicLink.href = `order.php?type=${category}&package=basic`;
        if (premiumLink) premiumLink.href = `order.php?type=${category}&package=premium`;

    </script>

</body>

</html>