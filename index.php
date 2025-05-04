<?php
session_start();
require_once 'functions.php';

// Cek apakah user sudah login, jika belum redirect ke login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$is_logged_in = isset($_SESSION['user_id']);
$features = getAllFeatures();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Eduverse - Platform Pembelajaran Interaktif</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <style>
    /* Custom styles */
    body, html {
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }
    
    .wrapper {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    
    .navbar-custom {
      background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
      padding: 1rem 1.5rem;
    }
    
    .sidebar {
      background: linear-gradient(180deg, #004a73 0%, #003557 100%);
      min-height: calc(100vh - 136px);
      padding-top: 1rem;
    }
    
    .sidebar .nav-link {
      color: rgba(255,255,255,0.85);
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      margin: 0.3rem 1rem;
      transition: all 0.3s ease;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: rgba(255,255,255,0.1);
      color: white;
      transform: translateX(5px);
    }
    
    .sidebar .nav-link i {
      margin-right: 10px;
    }
    
    .content {
      padding: 2rem;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      margin: 1rem;
    }
    
    .content-section {
      animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .footer {
      background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
      color: white;
      padding: 1rem;
      margin-top: auto;
    }
    
    /* Card styling */
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 1rem;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        min-height: auto;
      }
      
      .content {
        margin: 0.5rem;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Navbar dengan tambahan menu login/register -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">
          <img src="asset\lgeduvrs.png" alt="Eduverse Logo" class="login-logo" style="height: 40px;">
          <span class="navbar-brand">Eduverse</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <?php if ($is_logged_in): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                  <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                  <li><a class="dropdown-item" href="progress.php">Progress</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0">
          <nav class="sidebar h-100">
            <div class="nav flex-column">
              <a class="nav-link active" href="#home" onclick="showContent('home', this)">
                <i class="bi bi-house-fill"></i> Beranda
              </a>
              <?php if($_SESSION['role'] === 'user'): ?>
              <a class="nav-link" href="#materi" onclick="showContent('materi', this)">
                <i class="bi bi-book-fill"></i> Materi
              </a>
              <a class="nav-link" href="#soal" onclick="showContent('soal', this)">
                <i class="bi bi-question-circle-fill"></i> Soal
              </a>
              <a class="nav-link" href="#jawaban" onclick="showContent('jawaban', this)">
                <i class="bi bi-check-circle-fill"></i> Jawaban
              </a>
              <?php endif; ?>
              <?php if($_SESSION['role'] === 'admin'): ?>
              <a class="nav-link" href="#features" onclick="showContent('features', this)">
                <i class="bi bi-star-fill"></i> Features
              </a>
              <a class="nav-link" href="#users" onclick="showContent('users', this)">
                <i class="bi bi-people-fill"></i> Users
              </a>
              <?php endif; ?>
              <?php if($_SESSION['role'] === 'user'): ?>
              <a class="nav-link" href="#tentang" onclick="showContent('tentang', this)">
                <i class="bi bi-info-circle-fill"></i> Tentang
              </a>
              <a class="nav-link" href="#kontak" onclick="showContent('kontak', this)">
                <i class="bi bi-envelope-fill"></i> Kontak
              </a>
              <?php endif; ?>
            </div>
          </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
          <main class="content">
            <div id="home" class="content-section">
              <h2 class="mb-4">Selamat Datang di Eduverse</h2>
              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Mulai Perjalanan Belajarmu</h5>
                      <p class="card-text">Selamat datang di Eduverse, platform pembelajaran interaktif yang akan membantumu mengembangkan kemampuan dalam bidang teknologi.</p>
                      <a href="#" class="btn btn-primary">Mulai Belajar</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Fitur Terbaru</h5>
                      <p class="card-text">Temukan berbagai fitur menarik untuk membantu proses pembelajaran Anda.</p>
                      <a href="#" class="btn btn-outline-primary">Pelajari Lebih Lanjut</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div id="materi" class="content-section" style="display: none;">
              <h2 class="mb-4">Materi Pembelajaran</h2>
              <div class="row">
                <?php
                $materiList = getAllMateri();
                if (empty($materiList)): ?>
                  <div class="col-12">
                    <div class="alert alert-info">
                      Belum ada materi yang tersedia. Silakan cek kembali nanti.
                    </div>
                  </div>
                <?php else:
                foreach ($materiList as $materi):
                ?>
                <div class="col-md-4 mb-4">
                  <div class="card h-100">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($materi['judul']); ?></h5>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($materi['kategori'] ?? 'Umum'); ?></span>
                      </div>
                      <p class="card-text text-muted small mb-3">
                        <i class="bi bi-clock"></i> <?php echo date('d M Y', strtotime($materi['created_at'])); ?>
                      </p>
                      <p class="card-text"><?php echo htmlspecialchars($materi['deskripsi']); ?></p>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="detail_materi.php?id=<?php echo $materi['id']; ?>" class="btn btn-primary">
                          <i class="bi bi-book"></i> Baca Materi
                        </a>
                        <span class="text-muted small">
                          <i class="bi bi-eye"></i> <?php echo $materi['views'] ?? 0; ?> views
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; endif; ?>
              </div>

              <!-- Kategori Materi -->
              <div class="mt-5">
                <h3 class="mb-4">Kategori Materi</h3>
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="bi bi-code-slash display-4 text-primary mb-3"></i>
                        <h5>Pemrograman</h5>
                        <p class="text-muted">Belajar dasar-dasar pemrograman</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="bi bi-layout-text-window display-4 text-primary mb-3"></i>
                        <h5>Web Development</h5>
                        <p class="text-muted">Membangun website modern</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="bi bi-phone display-4 text-primary mb-3"></i>
                        <h5>Mobile Apps</h5>
                        <p class="text-muted">Pengembangan aplikasi mobile</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <div class="card-body text-center">
                        <i class="bi bi-database display-4 text-primary mb-3"></i>
                        <h5>Database</h5>
                        <p class="text-muted">Manajemen dan pengolahan data</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Materi Populer -->
              <div class="mt-5">
                <h3 class="mb-4">Materi Populer</h3>
                <div class="list-group">
                  <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">Dasar-dasar HTML & CSS</h5>
                      <small class="text-muted">3 hari yang lalu</small>
                    </div>
                    <p class="mb-1">Pelajari dasar-dasar HTML dan CSS untuk membangun website modern.</p>
                    <small class="text-muted">
                      <i class="bi bi-eye"></i> 1.2k views | 
                      <i class="bi bi-star-fill text-warning"></i> 4.8
                    </small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">JavaScript Modern</h5>
                      <small class="text-muted">1 minggu yang lalu</small>
                    </div>
                    <p class="mb-1">Pelajari JavaScript modern dengan fitur-fitur terbaru.</p>
                    <small class="text-muted">
                      <i class="bi bi-eye"></i> 980 views | 
                      <i class="bi bi-star-fill text-warning"></i> 4.7
                    </small>
                  </a>
                  <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">PHP & MySQL</h5>
                      <small class="text-muted">2 minggu yang lalu</small>
                    </div>
                    <p class="mb-1">Membangun aplikasi web dinamis dengan PHP dan MySQL.</p>
                    <small class="text-muted">
                      <i class="bi bi-eye"></i> 850 views | 
                      <i class="bi bi-star-fill text-warning"></i> 4.6
                    </small>
                  </a>
                </div>
              </div>
            </div>

            <div id="soal" class="content-section" style="display: none;">
              <h2 class="mb-4">Soal</h2>
              <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Soal HTML Dasar</h5>
                    <small class="text-muted">3 hari yang lalu</small>
                  </div>
                  <p class="mb-1">Latihan membuat struktur HTML dasar</p>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Soal CSS Flexbox</h5>
                    <small class="text-muted">5 hari yang lalu</small>
                  </div>
                  <p class="mb-1">Latihan layout dengan Flexbox</p>
                </a>
              </div>
            </div>

            <div id="jawaban" class="content-section" style="display: none;">
              <h2 class="mb-4">Jawaban</h2>
              <div class="alert alert-info">
                Silakan selesaikan soal terlebih dahulu sebelum melihat jawaban.
              </div>
            </div>

            <div id="tentang" class="content-section" style="display: none;">
              <h2 class="mb-4">Tentang</h2>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tentang Website</h5>
                  <p class="card-text">Website ini dibuat sebagai platform pembelajaran interaktif.</p>
                </div>
              </div>
            </div>

            <div id="kontak" class="content-section" style="display: none;">
              <h2 class="mb-4">Kontak</h2>
              <div class="card">
                <div class="card-body">
                  <form>
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="nama">
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                      <label for="pesan" class="form-label">Pesan</label>
                      <textarea class="form-control" id="pesan" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                  </form>
                </div>
              </div>
            </div>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div id="features" class="content-section" style="display: none;">
              <h2 class="mb-4">Kelola Fitur Eduverse</h2>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-primary" onclick="editFeature()">
                      <i class="bi bi-plus-lg"></i> Tambah Fitur
                    </button>
                  </div>
                  
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Icon</th>
                          <th>Judul</th>
                          <th>Deskripsi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($features as $feature): ?>
                        <tr>
                          <td><i class="bi <?= htmlspecialchars($feature['icon']) ?>"></i></td>
                          <td><?= htmlspecialchars($feature['title']) ?></td>
                          <td><?= htmlspecialchars($feature['description']) ?></td>
                          <td>
                            <button class="btn btn-sm btn-primary" onclick="editFeature(<?= $feature['id'] ?>)">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFeature(<?= $feature['id'] ?>)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal untuk menambah/mengedit fitur -->
            <div class="modal fade" id="featureModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit Fitur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form id="featureForm">
                      <input type="hidden" id="featureId" name="id">
                      <div class="mb-3">
                        <label for="icon" class="form-label">Icon (Bootstrap Icons)</label>
                        <input type="text" class="form-control" id="icon" name="icon" required>
                        <div class="form-text">Contoh: bi-book, bi-laptop, bi-graph-up</div>
                      </div>
                      <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                      </div>
                      <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveFeature()">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div id="users" class="content-section" style="display: none;">
              <h2 class="mb-4">Data Users</h2>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-primary" onclick="editUser()">
                      <i class="bi bi-plus-lg"></i> Tambah User
                    </button>
                  </div>
                  
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Nama Lengkap</th>
                          <th>Role</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $users = getAllUsers();
                        foreach ($users as $user): 
                        ?>
                        <tr>
                          <td><?= htmlspecialchars($user['id']) ?></td>
                          <td><?= htmlspecialchars($user['username']) ?></td>
                          <td><?= htmlspecialchars($user['email']) ?></td>
                          <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                          <td><?= htmlspecialchars($user['role']) ?></td>
                          <td>
                            <button class="btn btn-sm btn-primary" onclick="editUser(<?= $user['id'] ?>)">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id'] ?>)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal untuk menambah/mengedit user -->
            <div class="modal fade" id="userModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Tambah/Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form id="userForm">
                      <input type="hidden" id="userId" name="id">
                      <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                      </div>
                      <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                          <option value="user">User</option>
                          <option value="admin">Admin</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Simpan</button>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </main>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center py-3">
      <div class="container">
        <span>&copy; 2025 Eduverse. All rights reserved.</span>
      </div>
    </footer>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
    function showContent(sectionId, linkElement) {
      // Hide all content sections
      const sections = document.querySelectorAll('.content-section');
      sections.forEach(sec => sec.style.display = 'none');

      // Remove active class from all nav links
      const links = document.querySelectorAll('.nav-link');
      links.forEach(link => link.classList.remove('active'));

      // Show selected content
      const selectedSection = document.getElementById(sectionId);
      if (selectedSection) selectedSection.style.display = 'block';

      // Set active class on clicked link
      if (linkElement) linkElement.classList.add('active');
    }

    function saveUser() {
      // Ambil form
      const form = document.getElementById('userForm');
      
      // Validasi form
      const username = form.username.value.trim();
      const email = form.email.value.trim();
      const nama_lengkap = form.nama_lengkap.value.trim();
      const role = form.role.value;
      const password = form.password.value;
      const userId = form.id.value;

      // Debug log
      console.log('Form values:', {
        username,
        email,
        nama_lengkap,
        role,
        password,
        userId
      });

      // Validasi field wajib
      if (!username) {
        alert('Username harus diisi!');
        form.username.focus();
        return;
      }
      if (!email) {
        alert('Email harus diisi!');
        form.email.focus();
        return;
      }
      if (!nama_lengkap) {
        alert('Nama lengkap harus diisi!');
        form.nama_lengkap.focus();
        return;
      }
      if (!role) {
        alert('Role harus dipilih!');
        form.role.focus();
        return;
      }

      // Validasi email
      if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        alert('Format email tidak valid!');
        form.email.focus();
        return;
      }

      // Validasi password untuk user baru
      if (!userId && !password) {
        alert('Password wajib diisi untuk user baru!');
        form.password.focus();
        return;
      }

      // Buat objek data
      const formData = new FormData();
      formData.append('id', userId);
      formData.append('username', username);
      formData.append('email', email);
      formData.append('nama_lengkap', nama_lengkap);
      formData.append('role', role);
      if (password) {
        formData.append('password', password);
      }
      
      // Debug log
      console.log('Sending data:', Object.fromEntries(formData));
      
      // Kirim data ke server
      fetch('admin/save_user.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log('Server response:', data);
        if (data.success) {
          // Tutup modal
          const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
          modal.hide();
          
          // Refresh halaman
          location.reload();
        } else {
          alert(data.message || 'Terjadi kesalahan saat menyimpan data');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
      });
    }

    // Fungsi untuk menampilkan modal
    function editUser(id = null) {
      const form = document.getElementById('userForm');
      
      if (id) {
        // Ambil data user
        fetch(`admin/get_user.php?id=${id}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              form.id.value = data.user.id;
              form.username.value = data.user.username;
              form.email.value = data.user.email;
              form.nama_lengkap.value = data.user.nama_lengkap;
              form.role.value = data.user.role;
              form.password.value = '';
            } else {
              alert(data.message);
            }
          });
      } else {
        // Reset form untuk user baru
        form.reset();
        form.role.value = 'user';
      }
      
      // Tampilkan modal
      new bootstrap.Modal(document.getElementById('userModal')).show();
    }

    function deleteUser(id) {
      if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        
        fetch('admin/delete_user.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.message);
          }
        });
      }
    }

    function saveFeature() {
      // Ambil form
      const form = document.getElementById('featureForm');
      
      // Validasi form
      const icon = form.icon.value.trim();
      const title = form.title.value.trim();
      const description = form.description.value.trim();
      const featureId = form.id.value;

      // Validasi field wajib
      if (!icon) {
        alert('Icon harus diisi!');
        form.icon.focus();
        return;
      }
      if (!title) {
        alert('Judul harus diisi!');
        form.title.focus();
        return;
      }
      if (!description) {
        alert('Deskripsi harus diisi!');
        form.description.focus();
        return;
      }

      // Buat objek data
      const formData = new FormData();
      formData.append('id', featureId);
      formData.append('icon', icon);
      formData.append('title', title);
      formData.append('description', description);
      
      // Kirim data ke server
      fetch('admin/save_feature.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          // Tutup modal
          const modal = bootstrap.Modal.getInstance(document.getElementById('featureModal'));
          modal.hide();
          
          // Refresh halaman
          location.reload();
        } else {
          alert(data.message || 'Terjadi kesalahan saat menyimpan fitur');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan fitur');
      });
    }

    function editFeature(id = null) {
      const form = document.getElementById('featureForm');
      
      if (id) {
        // Ambil data fitur
        fetch(`admin/get_feature.php?id=${id}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              form.id.value = data.feature.id;
              form.icon.value = data.feature.icon;
              form.title.value = data.feature.title;
              form.description.value = data.feature.description;
            } else {
              alert(data.message || 'Gagal mengambil data fitur');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data fitur');
          });
      } else {
        // Reset form untuk fitur baru
        form.reset();
        form.id.value = '';
      }
      
      // Tampilkan modal
      new bootstrap.Modal(document.getElementById('featureModal')).show();
    }

    function deleteFeature(id) {
      if (confirm('Apakah Anda yakin ingin menghapus fitur ini?')) {
        const formData = new FormData();
        formData.append('id', id);
        
        fetch('admin/delete_feature.php', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            alert('Fitur berhasil dihapus');
            location.reload();
          } else {
            alert(data.message || 'Gagal menghapus fitur');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menghapus fitur: ' + error.message);
        });
      }
    }
  </script>
</body>
</html>

