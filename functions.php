<?php
require_once 'config.php';

// Fungsi untuk registrasi user baru
function registerUser($username, $password, $email, $nama_lengkap) {
    global $conn;
    
    try {
        // Cek apakah username atau email sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            return false;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user baru
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, nama_lengkap, created_at) VALUES (?, ?, ?, ?, NOW())");
        $result = $stmt->execute([$username, $hashed_password, $email, $nama_lengkap]);
        
        return $result;
    } catch(PDOException $e) {
        error_log("Error in registerUser: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk login
function loginUser($username, $password) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    } catch(PDOException $e) {
        return false;
    }
}

// Fungsi untuk mengambil semua materi
function getAllMateri() {
    global $conn;
    
    try {
        $stmt = $conn->query("SELECT * FROM materi ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// Fungsi untuk mengambil soal berdasarkan materi
function getSoalByMateri($materi_id) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT * FROM soal WHERE materi_id = ?");
        $stmt->execute([$materi_id]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}

// Fungsi untuk menyimpan jawaban user
function saveJawaban($user_id, $soal_id, $jawaban) {
    global $conn;
    
    try {
        // Ambil jawaban benar dari database
        $stmt = $conn->prepare("SELECT jawaban_benar FROM soal WHERE id = ?");
        $stmt->execute([$soal_id]);
        $soal = $stmt->fetch();
        
        $is_correct = ($jawaban === $soal['jawaban_benar']);
        
        $stmt = $conn->prepare("INSERT INTO jawaban_user (user_id, soal_id, jawaban_user, is_correct) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $soal_id, $jawaban, $is_correct]);
    } catch(PDOException $e) {
        return false;
    }
}

// Fungsi untuk update progress belajar
function updateProgress($user_id, $materi_id, $status, $progress) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("INSERT INTO progress_belajar (user_id, materi_id, status, progress_percent) 
                               VALUES (?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE 
                               status = VALUES(status), 
                               progress_percent = VALUES(progress_percent),
                               last_accessed = CURRENT_TIMESTAMP");
        return $stmt->execute([$user_id, $materi_id, $status, $progress]);
    } catch(PDOException $e) {
        return false;
    }
}

// Fungsi untuk mendapatkan konten halaman
function getContent($page) {
    global $conn;
    
    try {
        $stmt = $conn->prepare("SELECT content FROM pages WHERE page_name = ?");
        $stmt->execute([$page]);
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['content'];
        }
        
        return '';
    } catch(PDOException $e) {
        error_log("Error in getContent: " . $e->getMessage());
        return '';
    }
}

// Fungsi untuk mengupdate konten halaman
function updateContent($page, $content) {
    global $conn;
    
    try {
        // Cek apakah halaman sudah ada
        $check_stmt = $conn->prepare("SELECT id FROM pages WHERE page_name = ?");
        $check_stmt->execute([$page]);
        
        if ($check_stmt->rowCount() > 0) {
            // Update konten yang sudah ada
            $query = "UPDATE pages SET content = ? WHERE page_name = ?";
        } else {
            // Buat konten baru
            $query = "INSERT INTO pages (page_name, content) VALUES (?, ?)";
        }
        
        $stmt = $conn->prepare($query);
        return $stmt->execute([$content, $page]);
    } catch(PDOException $e) {
        error_log("Error in updateContent: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk menu
function getAllMenus() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT * FROM menus ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getAllMenus: " . $e->getMessage());
        return [];
    }
}

function getMenu($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM menus WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getMenu: " . $e->getMessage());
        return false;
    }
}

function createMenu($title, $description, $icon, $link) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO menus (title, description, icon, link) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $icon, $link]);
    } catch(PDOException $e) {
        error_log("Error in createMenu: " . $e->getMessage());
        return false;
    }
}

function updateMenu($id, $title, $description, $icon, $link) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE menus SET title = ?, description = ?, icon = ?, link = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $icon, $link, $id]);
    } catch(PDOException $e) {
        error_log("Error in updateMenu: " . $e->getMessage());
        return false;
    }
}

function deleteMenu($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM menus WHERE id = ?");
        return $stmt->execute([$id]);
    } catch(PDOException $e) {
        error_log("Error in deleteMenu: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk kursus
function getAllCourses() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT * FROM courses ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getAllCourses: " . $e->getMessage());
        return [];
    }
}

function getCourse($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getCourse: " . $e->getMessage());
        return false;
    }
}

function createCourse($title, $description, $image, $price) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO courses (title, description, image, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $image, $price]);
    } catch(PDOException $e) {
        error_log("Error in createCourse: " . $e->getMessage());
        return false;
    }
}

function updateCourse($id, $title, $description, $image, $price) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE courses SET title = ?, description = ?, image = ?, price = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $image, $price, $id]);
    } catch(PDOException $e) {
        error_log("Error in updateCourse: " . $e->getMessage());
        return false;
    }
}

function deleteCourse($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    } catch(PDOException $e) {
        error_log("Error in deleteCourse: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk user
function getAllUsers() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT * FROM users ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getAllUsers: " . $e->getMessage());
        return [];
    }
}

function getUser($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getUser: " . $e->getMessage());
        return false;
    }
}

function createUser($username, $password, $email, $nama_lengkap, $role = 'user') {
    global $conn;
    try {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, nama_lengkap, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $hashed_password, $email, $nama_lengkap, $role]);
    } catch(PDOException $e) {
        error_log("Error in createUser: " . $e->getMessage());
        return false;
    }
}

function updateUser($id, $username, $email, $nama_lengkap, $role) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, nama_lengkap = ?, role = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $nama_lengkap, $role, $id]);
    } catch(PDOException $e) {
        error_log("Error in updateUser: " . $e->getMessage());
        return false;
    }
}

function updateUserPassword($id, $password) {
    global $conn;
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed_password, $id]);
    } catch(PDOException $e) {
        error_log("Error in updateUserPassword: " . $e->getMessage());
        return false;
    }
}

function deleteUser($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    } catch(PDOException $e) {
        error_log("Error in deleteUser: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk mendapatkan semua fitur
function getAllFeatures() {
    global $conn;
    try {
        $stmt = $conn->query("SELECT * FROM features ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getAllFeatures: " . $e->getMessage());
        return [];
    }
}

// Fungsi untuk mendapatkan fitur berdasarkan ID
function getFeature($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM features WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error in getFeature: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk membuat fitur baru
function createFeature($icon, $title, $description) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO features (icon, title, description) VALUES (?, ?, ?)");
        return $stmt->execute([$icon, $title, $description]);
    } catch(PDOException $e) {
        error_log("Error in createFeature: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk memperbarui fitur
function updateFeature($id, $icon, $title, $description) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE features SET icon = ?, title = ?, description = ? WHERE id = ?");
        return $stmt->execute([$icon, $title, $description, $id]);
    } catch(PDOException $e) {
        error_log("Error in updateFeature: " . $e->getMessage());
        return false;
    }
}

// Fungsi untuk menghapus fitur
function deleteFeature($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM features WHERE id = ?");
        return $stmt->execute([$id]);
    } catch(PDOException $e) {
        error_log("Error in deleteFeature: " . $e->getMessage());
        return false;
    }
}
?>
