
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Office Sekolah</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .card {
            border: none;
            border-radius: 8px;
            transition: box-shadow 0.3s ease;
            background-color: #fff;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: 500;
            color: #007bff;
        }
        .icon {
            font-size: 1.8rem;
            color: #007bff;
            margin-bottom: 10px;
        }
        .text-overlay {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 10px;
            color: #333;
            border-radius: 5px;
        }
        .footer {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }
    </style>


    <!-- Header -->
    <div class="header">
    <h2>Selamat Datang di Galeri Foto Sekolah</h2>
    <p>Halo, <?= session()->get('username') ?>! Lihatlah koleksi momen terbaik dari sekolah kami.</p>
</div>

<div class="container mt-4">
    <!-- Informasi Galeri Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center p-4">
                <div class="card-body">
                    <i class="fas fa-images icon"></i>
                    <h5 class="card-title">Total Album</h5>
                    <p class="card-text"><?= $total_album ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-center p-4">
                <div class="card-body">
                    <i class="fas fa-camera icon"></i>
                    <h5 class="card-title">Total Foto</h5>
                    <p class="card-text"><?= $total_foto ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Foto Terbaru -->
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mb-4">Galeri Foto Terbaru</h3>
        </div>
        
            <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="card">
                    <img src="<?= base_url('uploads/' . $photo['file_path']) ?>" class="card-img-top" alt="<?= $photo['title'] ?>">
                    <div class="card-body">
                        <h6 class="card-title"><?= $photo['title'] ?></h6>
                        <p class="card-text"><?= $photo['description'] ?></p>
                    </div>
                </div>
            </div>
        
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2023 Galeri Foto Sekolah | Koleksi Momen Terbaik</p>
</div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

