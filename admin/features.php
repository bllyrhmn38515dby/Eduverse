<?php
session_start();
require_once '../functions.php';

// Cek apakah user sudah login dan memiliki role admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$features = getAllFeatures();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Fitur - Admin Eduverse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Kelola Fitur Eduverse</h2>
        
        <button class="btn btn-primary mb-3" onclick="showFeatureModal()">
            <i class="bi bi-plus-lg"></i> Tambah Fitur
        </button>

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
                        <td><i class="bi <?php echo htmlspecialchars($feature['icon']); ?> feature-icon"></i></td>
                        <td><?php echo htmlspecialchars($feature['title']); ?></td>
                        <td><?php echo htmlspecialchars($feature['description']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editFeature(<?php echo $feature['id']; ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFeature(<?php echo $feature['id']; ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
                        <input type="hidden" id="featureId">
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon (Bootstrap Icons)</label>
                            <input type="text" class="form-control" id="icon" required>
                            <small class="text-muted">Contoh: bi-book, bi-laptop, bi-graph-up</small>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" rows="3" required></textarea>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const featureModal = new bootstrap.Modal(document.getElementById('featureModal'));
        
        function showFeatureModal() {
            document.getElementById('featureForm').reset();
            document.getElementById('featureId').value = '';
            featureModal.show();
        }

        function editFeature(id) {
            fetch(`get_feature.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('featureId').value = data.id;
                    document.getElementById('icon').value = data.icon;
                    document.getElementById('title').value = data.title;
                    document.getElementById('description').value = data.description;
                    featureModal.show();
                });
        }

        function saveFeature() {
            const formData = new FormData();
            formData.append('id', document.getElementById('featureId').value);
            formData.append('icon', document.getElementById('icon').value);
            formData.append('title', document.getElementById('title').value);
            formData.append('description', document.getElementById('description').value);

            fetch('save_feature.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            });
        }

        function deleteFeature(id) {
            if (confirm('Apakah Anda yakin ingin menghapus fitur ini?')) {
                fetch('delete_feature.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    </script>
</body>
</html> 