<?php
session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Eduverse</title>
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

        .about-hero {
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
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .team-member {
            text-align: center;
            margin-bottom: 2rem;
        }

        .team-member img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 5px solid var(--primary-color);
        }

        .mission-vision {
            background-color: #f8f9fa;
            padding: 4rem 0;
            margin: 3rem 0;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            width: 2px;
            background: var(--primary-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -1px;
        }

        .timeline-item {
            margin-bottom: 3rem;
            position: relative;
        }

        .timeline-content {
            padding: 1.5rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            width: 45%;
            margin-left: auto;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 0;
            margin-right: auto;
        }

        .timeline-content::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .timeline-item:nth-child(odd) .timeline-content::before {
            left: -60px;
        }

        .timeline-item:nth-child(even) .timeline-content::before {
            right: -60px;
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
                        <a class="nav-link" href="landing.php#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">Tentang</a>
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
    <section class="about-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Tentang Eduverse</h1>
            <p class="lead">Platform pembelajaran interaktif untuk masa depan pendidikan yang lebih baik</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Visi & Misi -->
        <section class="mission-vision">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" data-aos="fade-right">
                        <h2 class="mb-4">Visi Kami</h2>
                        <p class="lead">Menjadi platform pembelajaran online terdepan yang menginspirasi dan memberdayakan generasi masa depan.</p>
                        <p>Kami berkomitmen untuk memberikan akses pendidikan berkualitas kepada semua orang, di mana pun mereka berada.</p>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <h2 class="mb-4">Misi Kami</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                Menyediakan materi pembelajaran berkualitas tinggi
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                Mengembangkan metode pembelajaran yang inovatif
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                Membangun komunitas pembelajaran yang kolaboratif
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                Mendorong pengembangan keterampilan digital
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sejarah -->
        <section class="timeline">
            <h2 class="text-center mb-5">Perjalanan Kami</h2>
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-content">
                    <h4>2020</h4>
                    <p>Eduverse didirikan dengan visi untuk merevolusi cara belajar online</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-content">
                    <h4>2021</h4>
                    <p>Peluncuran platform dengan fitur pembelajaran interaktif pertama</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-content">
                    <h4>2022</h4>
                    <p>Ekspansi ke berbagai kota di Indonesia dan pencapaian 10.000 pengguna aktif</p>
                </div>
            </div>
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-content">
                    <h4>2023</h4>
                    <p>Peluncuran fitur pembelajaran adaptif dan kolaboratif</p>
                </div>
            </div>
        </section>

        <!-- Tim Kami -->
        <section class="py-5">
            <h2 class="text-center mb-5">Tim Kami</h2>
            <div class="row">
                <div class="col-md-4 team-member" data-aos="fade-up">
                    <img src="asset/img1profile.jpg" alt="Team Member">
                    <h4>Budi Santoso</h4>
                    <p class="text-muted">Founder & CEO</p>
                </div>
                <div class="col-md-4 team-member" data-aos="fade-up" data-aos-delay="100">
                    <img src="asset/img2profile.jpg" alt="Team Member">
                    <h4>Ani Wijaya</h4>
                    <p class="text-muted">Head of Education</p>
                </div>
                <div class="col-md-4 team-member" data-aos="fade-up" data-aos-delay="200">
                    <img src="asset/img3profile.jpg" alt="Team Member">
                    <h4>Rudi Hartono</h4>
                    <p class="text-muted">Technical Lead</p>
                </div>
            </div>
        </section>
    </div>

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
                        <li><a href="about.php" class="text-white">Tentang</a></li>
                        <li><a href="landing.php#contact" class="text-white">Kontak</a></li>
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