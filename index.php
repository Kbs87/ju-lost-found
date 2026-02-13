<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jimma University Lost and Found - The official portal to report and find lost items on campus.">
    <title>Jimma University | Lost & Found</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="#" class="logo">
                <i class="fa-solid fa-building-columns"></i> JU<span>Lost&Found</span>
            </a>
            <div class="nav-links">
                <a href="#home" class="active">Home</a>
                <a href="#browse">Browse Items</a>
                <a href="#about">About</a>
                <button id="reportBtn" class="btn btn-primary">Report Lost/Found</button>
            </div>
            <div class="mobile-toggle">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container hero-content">
            <h1>Lost Something? <br>Let's Help You <span class="highlight">Find It.</span></h1>
            <p>The official community-driven lost and found portal for Jimma University students and staff.</p>
            <div class="hero-buttons">
                <a href="#browse" class="btn btn-outline">Search Items</a>
                <button onclick="openModal('lost')" class="btn btn-primary">I Lost Something</button>
            </div>
        </div>
        <div class="hero-shape"></div>
    </section>

    <!-- Search & Filter Section -->
    <section id="browse" class="browse-section">
        <div class="container">
            <div class="section-header">
                <h2>Recent Activity</h2>
                <div class="tabs">
                    <button class="tab-btn active" data-type="all">All</button>
                    <button class="tab-btn" data-type="lost">Lost</button>
                    <button class="tab-btn" data-type="found">Found</button>
                </div>
            </div>

            <!-- Items Grid -->
            <div id="itemsGrid" class="items-grid">
                <!-- Items will be loaded here via JS -->
                <div class="loading-spinner">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Loading...
                </div>
            </div>
        </div>
    </section>

    <!-- About/Info Section -->
    <section id="about" class="info-section">
        <div class="container">
            <div class="info-card">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <h3>Community Driven</h3>
                <p>Help your fellow students by verifying and returning items you find.</p>
            </div>
            <div class="info-card">
                <i class="fa-solid fa-shield-halved"></i>
                <h3>Secure & Safe</h3>
                <p>We ensure that contact details are only shared when necessary.</p>
            </div>
            <div class="info-card">
                <i class="fa-solid fa-bolt"></i>
                <h3>Fast Recovery</h3>
                <p>Our centralized system speeds up the process of reclaiming lost goods.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container footer-content">
            <div class="footer-left">
                <h4>Jimma University</h4>
                <p>Lost & Found Portal</p>
                <p>&copy; <?php echo date('Y'); ?> All Rights Reserved.</p>
            </div>
            <div class="footer-right">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Admin</a>
            </div>
        </div>
    </footer>

    <!-- Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Report an Item</h3>
                <button class="close-modal"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <input type="hidden" name="type" id="reportType" value="lost">
                    
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" id="item_name" name="item_name" placeholder="e.g. Blue Nike Wallet" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Status</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="display_type" value="lost" checked onchange="document.getElementById('reportType').value='lost'">
                                <span>I Lost It</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="display_type" value="found" onchange="document.getElementById('reportType').value='found'">
                                <span>I Found It</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group half">
                        <div>
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" placeholder="Where was it?" required>
                        </div>
                        <div>
                            <label for="event_date">Date</label>
                            <input type="date" id="event_date" name="event_date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3" placeholder="Distinguishing features..." required></textarea>
                    </div>

                    <div class="form-group half">
                        <div>
                            <label for="contact_name">Your Name</label>
                            <input type="text" id="contact_name" name="contact_name" required>
                        </div>
                        <div>
                            <label for="contact_phone">Phone Number</label>
                            <input type="tel" id="contact_phone" name="contact_phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image (Optional)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-block">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
