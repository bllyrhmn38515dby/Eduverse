<?php
session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur - Eduverse</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e88e5;
            --secondary-color: #1565c0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem 1.5rem;
        }

        .features-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 5rem 0;
            margin-bottom: 3rem;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            background: white;
            padding: 2rem;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .feature-section {
            padding: 4rem 0;
        }

        .feature-section:nth-child(even) {
            background-color: #f8f9fa;
        }

        .feature-image {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="landing.php">
                <img src="asset\lgeduvrs.png" alt="Eduverse Logo" class="login-logo" style="height: 40px;">
                <span class="navbar-brand">Eduverse</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="features.php">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landing.php#testimonials">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="landing.php#contact">Kontak</a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light px-4 ms-2" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light px-4 ms-2" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="features-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Fitur Eduverse</h1>
            <p class="lead">Temukan berbagai fitur menarik yang akan meningkatkan pengalaman belajar Anda</p>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="feature-section">
        <div class="container">
            <div class="row">
                <?php
                $features = getAllFeatures();
                foreach ($features as $feature):
                ?>
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="feature-card text-center">
                        <i class="bi <?php echo htmlspecialchars($feature['icon']); ?> feature-icon"></i>
                        <h3 class="h4 mb-3"><?php echo htmlspecialchars($feature['title']); ?></h3>
                        <p class="text-muted"><?php echo htmlspecialchars($feature['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Feature Details -->
    <section class="feature-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <h2 class="mb-4">Pembelajaran Interaktif</h2>
                    <p class="lead mb-4">Belajar menjadi lebih menyenangkan dengan fitur interaktif kami.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Video pembelajaran berkualitas tinggi
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Kuis interaktif untuk menguji pemahaman
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Diskusi langsung dengan pengajar
                        </li>
                    </ul>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <img src="asset/img1landing.jpg" alt="Pembelajaran Interaktif" class="img-fluid feature-image">
                </div>
            </div>
        </div>
    </section>

    <section class="feature-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-md-2" data-aos="fade-left">
                    <h2 class="mb-4">Progress Tracking</h2>
                    <p class="lead mb-4">Pantau perkembangan belajar Anda dengan mudah.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Dashboard progress belajar
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Sertifikat kelulusan
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Laporan detail pencapaian
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 order-md-1" data-aos="fade-right">
                    <img src="asset/img2landing.jpg" alt="Progress Tracking" class="img-fluid feature-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Eduverse</h5>
                    <p>Platform pembelajaran interaktif untuk masa depan pendidikan yang lebih baik.</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="landing.php" class="text-white">Home</a></li>
                        <li><a href="features.php" class="text-white">Fitur</a></li>
                        <li><a href="about.php" class="text-white">Tentang</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-geo-alt-fill"></i> Jakarta, Indonesia</li>
                        <li><i class="bi bi-telephone-fill"></i> +62 123 4567 890</li>
                        <li><i class="bi bi-envelope-fill"></i> info@eduverse.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Eduverse. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html> 