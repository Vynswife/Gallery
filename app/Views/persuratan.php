<style>
    /* Make the buttons smaller */
.btn-sm {
    padding: 0.25rem 0.5rem; /* Smaller padding */
    font-size: 0.75rem; /* Reduce font size */
    line-height: 1.5; /* Adjust line height for smaller buttons */
}

/* Optional: Styling specifically for the 'Download' button */
.btn-danger.btn-sm {
    font-size: 0.75rem; /* Smaller font size */
    padding: 0.25rem 0.5rem; /* Smaller padding */
}

/* Optional: Styling specifically for the 'Ajukan' button */
.btn-info.btn-sm {
    font-size: 0.75rem; /* Smaller font size */
    padding: 0.25rem 0.5rem; /* Smaller padding */
}
.small-text {
    font-size: 0.85rem;  /* Adjust the font size as needed */
}

</style>
<!-- persuratan.php -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Surat Masuk</h1>

    <!-- Main Content Area -->
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Surat Masuk</h6>
                <!-- Button container with spacing for neatness -->
                <div class="d-flex">
                    <!-- Tulis Surat Masuk Button -->
                    
                    
                    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#tambahFotoModal">+ Upload Another Photo</button>

                    <!-- Tambah Folder Button -->
                    <?php if (session()->get('level') == 2||session()->get('level') == 4): ?>   
                    <button class="btn btn-info" data-toggle="modal" data-target="#tambahFolderModal">+ Add Album</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Upload</th>
                                <th>File Photo</th>
                                <th>Uploader</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jel)) { ?>
                                <?php foreach($jel as $surat): ?>
                                    <tr class="surat-row" data-status="<?= $surat->status_menunggu ?>">
                                        <td class="small-text"><?= $surat->judul ?></td>
                                        <td class="small-text"><?= $surat->deskripsi ?></td>
                                        <td class="small-text"><?= $surat->tanggal_buat ?></td>
                                        <td>
                                            <img src="<?= base_url('img/'.$surat->lokasi) ?>" width="80px" class="img-thumbnail" 
                                                 data-toggle="modal" data-target="#imageModal" 
                                                 data-file="<?= base_url('img/'.$surat->lokasi) ?>" alt="Surat Image">
                                        </td>
                                        <td class="small-text"><?= $surat->username ?></td>
                                        <td>
                                            <!-- Ajukan Button: Visible if user level is 2 -->
                                            <?php if (session()->get('level') == 2 || session()->get('level') == 4): ?>
        <!-- Update Photo Button -->
        <button class="btn btn-info btn-sm" data-toggle="modal" 
                data-id_foto="<?= $surat->id_foto ?>"
                data-judul="<?= htmlspecialchars($surat->judul, ENT_QUOTES, 'UTF-8') ?>"
                data-deskripsi="<?= htmlspecialchars($surat->deskripsi, ENT_QUOTES, 'UTF-8') ?>"
                data-lokasi="<?= $surat->lokasi ?>"
                data-target="#updatePhotoModal">
            <i class="fas fa-edit"></i> Update Foto
        </button>

        <!-- Add to Folder Button -->
        <button class="btn btn-warning btn-sm" data-toggle="modal" 
        data-id_foto="<?= $surat->id_foto ?>"
        data-target="#editFolderModal">
    <i class="fas fa-folder-open"></i> Masukan ke
</button>


        <!-- Delete (Set Status to Deleted) Button -->
        <form action="<?= base_url('home/delete_foto') ?>" method="post" style="display: inline;">
            <input type="hidden" name="id_foto" value="<?= $surat->id_foto ?>">
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data surat masuk</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Assigning Document to Folder (Visible only for level 2) -->
<div class="modal fade" id="editFolderModal" tabindex="-1" role="dialog" aria-labelledby="editFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url('home/e_album') ?>" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="editFolderModalLabel">Assign Document to Folder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Hidden Input for Foto ID -->
                    <input type="hidden" id="id_foto" name="id_foto"> <!-- Ensure input name is id_foto -->
                    
                    <!-- Folder Selection -->
                    <div class="form-group">
                        <label for="folder" class="font-weight-bold">Select Folder</label>
                        <p class="form-text text-muted mb-2">
                            Please choose the folder where this document will be stored.
                        </p>
                        <select class="form-control" name="album" id="folder" required>
                            <?php foreach($folders as $folder): ?>
                                <option value="<?= $folder->id_album ?>"><?= $folder->nama_album ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal for Updating Photo with Custom File Upload Style -->
<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('home/e_foto'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePhotoModalLabel"><i class="fas fa-image mr-2" id="image_icon"></i>Update Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- General Information Section -->
                    <h6 class="font-weight-bold">Informasi Umum</h6>
                    <p class="text-muted">Lengkapi informasi pada foto yang ingin diperbarui.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="modalJudul">Judul Foto</label>
                            <input type="text" class="form-control" id="modalJudul" name="judul" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modalDeskripsi">Deskripsi Foto</label>
                            <input type="text" class="form-control" id="modalDeskripsi" name="deskripsi" required>
                        </div>
                    </div>

                    <!-- File Upload Section with Custom Style -->
                    <div class="form-group">
                        <label for="modalFile">Upload Foto Baru</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control-file d-none" id="modalFile" name="lokasi" accept=".jpg,.jpeg,.png,.gif,.bmp" onchange="updateFileName(this)">
                            <button type="button" class="upload-btn" onclick="document.getElementById('modalFile').click()">Choose File</button>
                            <span id="file_name" class="ml-2 text-muted">No file chosen</span>
                        </div>
                        <small class="form-text text-muted">* Pilih file gambar baru jika ingin mengganti (hanya .jpg, .jpeg, .png, .gif, .bmp)</small>
                    </div>

                    <!-- Hidden Input for Photo ID -->
                    <input type="hidden" name="id_foto" id="id_foto" >
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for Adding New Folder -->
<div class="modal fade" id="tambahFolderModal" tabindex="-1" aria-labelledby="tambahFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="<?= base_url('home/t_album') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="tambahFolderModalLabel">Create New Album</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_folder" class="font-weight-bold">Album Name</label>
                        <input type="text" class="form-control" id="nama_folder" name="nama" placeholder="Enter album name" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="font-weight-bold">Description</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Enter description" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="upload_file_album">Upload Foto</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control-file d-none" id="upload_file_album" name="foto" accept=".jpg,.jpeg,.png" onchange="updateFileName(this, 'file_name_album')" required>
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('upload_file_album').click()">Choose File</button>
                            <span id="file_name_album" class="ml-2 text-muted">No file chosen</span>
                        </div>
                        <small class="form-text text-muted">* Hanya file gambar (.jpg, .jpeg, .png) yang diizinkan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Adding Foto -->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-labelledby="tambahFotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahFotoLabel"><i class="fas fa-image mr-2" id="image_icon"></i>Tambah Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadForm" action="<?= base_url('home/t_foto') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <h6 class="font-weight-bold">Informasi Umum</h6>
                    <p class="text-muted">Lengkapi informasi pada foto yang ingin ditambahkan.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="judul">Judul Foto</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_buat">Tanggal Foto</label>
                            <input type="date" class="form-control" id="tanggal_buat" name="tanggal_buat" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Foto</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="upload_file_foto">Upload Foto</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control-file d-none" id="upload_file_foto" name="foto" accept=".jpg,.jpeg,.png" onchange="updateFileName(this, 'file_name_foto')" required>
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('upload_file_foto').click()">Choose File</button>
                            <span id="file_name_foto" class="ml-2 text-muted">No file chosen</span>
                        </div>
                        <small class="form-text text-muted">* Hanya file gambar (.jpg, .jpeg, .png) yang diizinkan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to update the file name displayed after selecting a file
    function updateFileName(input, fileNameId) {
        const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
        document.getElementById(fileNameId).textContent = fileName;
    }

    // Reset form and handle modal actions when shown
    $('#tambahFolderModal').on('show.bs.modal', function () {
        $(this).find('form')[0].reset();
        document.getElementById('file_name_album').textContent = 'No file chosen'; // Reset file name display
    });

    $('#tambahFotoModal').on('show.bs.modal', function () {
        $(this).find('form')[0].reset();
        document.getElementById('file_name_foto').textContent = 'No file chosen'; // Reset file name display
    });
</script>





<style>
    .custom-file-upload {
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: 8px;
        background-color: #f8f9fa;
    }
    .upload-btn {
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: 6px 12px;
        background-color: #ffffff;
        cursor: pointer;
    }
    .upload-btn:hover {
        background-color: #e9ecef;
    }
    #file_name {
        flex-grow: 1;
        color: #6c757d;
        font-size: 14px;
    }
</style>




<!-- Modal for Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modal_image" src="" alt="Gambar Surat" class="modal-image img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>







<!-- Include this CSS for custom styling -->
<style>
    /* Apply Roboto Font to Modal */
    /* Apply Roboto Font to Modal */
.modal-content, .modal-header, .modal-body, .modal-footer {
    font-family: 'Roboto', sans-serif;
}

/* Modal Header */
.modal-header {
    background-color: #007bff; /* Adjust as needed */
    color: #fff;
    border-bottom: none;
}
.modal-title {
    font-weight: 700;
    font-size: 1.25rem;
}
.modal-header .close span {
    color: #fff;
}

/* Body Styling */
.modal-body {
    background-color: #f9f9f9;
}
.card {
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}
.card h6 {
    font-weight: 500;
    color: #333;
}
.table-borderless td {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
}

/* Button Styling */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    font-weight: 500;
    padding: 0.375rem 0.75rem; /* Adjust padding for smaller buttons */
    font-size: 0.875rem; /* Reduce font size */
}
.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    font-weight: 500;
    padding: 0.375rem 0.75rem; /* Adjust padding for smaller buttons */
    font-size: 0.875rem; /* Reduce font size */
}
.btn-primary:hover, .btn-secondary:hover {
    opacity: 0.85;
}

/* Footer buttons */
.modal-footer .btn {
    width: auto; /* Allow buttons to fit their content size */
    padding: 0.375rem 0.75rem; /* Adjust padding for smaller buttons */
    font-size: 0.875rem; /* Reduce font size */
    border-radius: 4px; /* Optional: Add border-radius for rounded corners */
}

</style>




<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<!-- Bootstrap and jQuery JS (required for Bootstrap 4 modals) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "No file chosen";
        document.getElementById('file_name').textContent = fileName;
    }
</script>
<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "No file chosen";
        document.getElementById('file_name1').textContent = fileName;
    }

    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // The button that triggered the modal (the image thumbnail)
        var fileUrl = button.data('file'); // Extract the file URL from the data-file attribute

        var modal = $(this);
        modal.find('.modal-body img').attr('src', fileUrl); // Set the src of the modal image
    });

</script>


<script>
    // Populate the modal with the photo details
    $('#updatePhotoModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idFoto = button.data('id_foto');
        var judul = button.data('judul');
        var deskripsi = button.data('deskripsi');

        var modal = $(this);
        modal.find('#id_foto').val(idFoto);
        modal.find('#modalJudul').val(judul);
        modal.find('#modalDeskripsi').val(deskripsi);
    });

    // Update file name display when a file is selected
    function updateFileName(input) {
        var fileName = input.files[0] ? input.files[0].name : "No file chosen";
        document.getElementById('file_name').textContent = fileName;
    }
</script>



<script>
    // Populate the modal with the Foto ID
    $('#editFolderModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var fotoId = button.data('id_foto'); // Correctly use id_foto here
        var modal = $(this);
        modal.find('#id_foto').val(fotoId); // Set id_foto in the hidden input field
    });
</script>

