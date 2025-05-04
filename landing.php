<?php
session_start();
// Jika sudah login, redirect ke index.php
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Eduverse</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* Custom CSS */
        :root {
            --primary-color: #1e88e5;
            --secondary-color: #1565c0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTQ0MCIgaGVpZ2h0PSI3NjUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IHgxPSI3MS41MTMlIiB5MT0iNTAlIiB4Mj0iMCUiIHkyPSI1MCUiIGlkPSJhIj48c3RvcCBzdG9wLWNvbG9yPSIjRkZGIiBzdG9wLW9wYWNpdHk9Ii4yNSIgb2Zmc2V0PSIwJSIvPjxzdG9wIHN0b3AtY29sb3I9IiNGRkYiIHN0b3Atb3BhY2l0eT0iMCIgb2Zmc2V0PSIxMDAlIi8+PC9saW5lYXJHcmFkaWVudD48L2RlZnM+PHBhdGggZD0iTTAgMGgxNDQwdjc2NUgweiIgZmlsbD0idXJsKCNhKSIgZmlsbC1ydWxlPSJldmVub2RkIi8+PC9zdmc+');
            opacity: 0.1;
            transform: rotate(45deg);
            top: -25%;
            left: -25%;
            pointer-events: none;
        }

        .navbar-landing {
            background-color: transparent !important;
            padding: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .navbar-landing.scrolled {
            background-color: white !important;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-landing.scrolled .nav-link,
        .navbar-landing.scrolled .navbar-brand {
            color: var(--primary-color) !important;
        }

        .hero-content {
            padding-top: 120px;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .stats-section {
            background-color: #f8f9fa;
            padding: 5rem 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-landing fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="asset\lgeduvrs.png" alt="Eduverse Logo" class="login-logo" style="height: 40px;">
                <span class="navbar-brand">Eduverse</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline px-4 ms-2" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline px-4 ms-2" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">Belajar Lebih Mudah dengan Eduverse</h1>
                    <p class="lead mb-4">Platform pembelajaran interaktif yang membantu Anda mengembangkan keterampilan digital dengan cara yang menyenangkan.</p>
                    <a href="register.php" class="btn btn-light btn-lg me-3">Mulai Belajar</a>
                    <a href="home.php" class="btn btn-outline-light btn-lg">Pelajari Lebih Lanjut</a>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="asset\img1landing.jpg" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Eduverse</h2>
            <div class="row">
                <?php
                require_once 'functions.php';
                $features = getAllFeatures();
                foreach ($features as $feature):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi <?php echo htmlspecialchars($feature['icon']); ?> display-4 text-primary mb-3"></i>
                            <h5 class="card-title"><?php echo htmlspecialchars($feature['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($feature['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <a href="features.php" class="btn btn-primary btn-lg me-2">Selengkapnya</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-4">Tentang Eduverse</h2>
                    <p class="lead">Platform pembelajaran interaktif untuk masa depan pendidikan yang lebih baik.</p>
                    <p>Eduverse hadir sebagai solusi pembelajaran online yang inovatif dan efektif. Kami berkomitmen untuk memberikan pengalaman belajar yang menyenangkan dan bermanfaat bagi semua pengguna.</p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                <span>Materi Berkualitas</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                <span>Pembelajaran Interaktif</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                <span>Fleksibel</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                <span>Terjangkau</span>
                            </div>
                        </div>
                    </div>
                    <a href="about.php" class="btn btn-primary btn-lg me-3">Selengkapnya</a>
                </div>
                <div class="col-md-6">
                    <img src="asset/img2landing.jpg" alt="Tentang Eduverse" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Apa Kata Mereka?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="asset/img1profile.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <small class="text-muted">Mahasiswa</small>
                                </div>
                            </div>
                            <p class="card-text">"Materi yang disajikan sangat mudah dipahami dan interaktif. Sangat membantu dalam proses belajar saya."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="asset/img2profile.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h5 class="mb-0">Ani Wijaya</h5>
                                    <small class="text-muted">Guru</small>
                                </div>
                            </div>
                            <p class="card-text">"Platform yang sangat bagus untuk pembelajaran online. Fitur-fiturnya lengkap dan mudah digunakan."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="asset/img3profile.jpg" alt="User" class="rounded-circle me-3" width="50">
                                <div>
                                    <h5 class="mb-0">Rudi Hartono</h5>
                                    <small class="text-muted">Karyawan</small>
                                </div>
                            </div>
                            <p class="card-text">"Sangat membantu untuk meningkatkan skill saya. Materi yang disajikan relevan dengan kebutuhan industri."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Hubungi Kami</h2>
            <div class="row">
                <!-- Form Kontak -->
                <div class="col-md-6 mb-4">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
                
                <!-- Google Maps -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Lokasi Kami</h5>
                            <div class="ratio ratio-4x3">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6666666666665!2d106.66666666666666!3d-6.166666666666666!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTAnMDAuMCJTIDEwNsKwNDAnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890!5m2!1sid!2sid" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                            <div class="mt-3">
                                <p class="mb-1"><i class="bi bi-geo-alt-fill text-primary"></i> Jl. Contoh No. 123, Jakarta</p>
                                <p class="mb-1"><i class="bi bi-telephone-fill text-primary"></i> +62 123 4567 890</p>
                                <p class="mb-0"><i class="bi bi-envelope-fill text-primary"></i> info@eduverse.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar-landing').classList.add('scrolled');
            } else {
                document.querySelector('.navbar-landing').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>