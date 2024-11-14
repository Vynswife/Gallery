<style>
    /* Make the buttons smaller */
/* Custom CSS to further reduce button size */
.btn-sm {
    padding: 0.2rem 0.5rem; /* Smaller padding for the button */
    font-size: 0.75rem; /* Reduce font size */
    line-height: 1.25; /* Adjust line height */
}

/* Custom style for PDF button */
.btn-danger.btn-sm {
    padding: 0.2rem 0.5rem; /* Smaller padding for the 'PDF' button */
    font-size: 0.75rem; /* Reduce font size */
}

/* Custom style for 'Ajukan' button */
.btn-info.btn-sm {
    padding: 0.2rem 0.5rem; /* Smaller padding for the 'Ajukan' button */
    font-size: 0.75rem; /* Reduce font size */
}

/* Custom class for smaller text */
.small-text {
    font-size: 0.85rem;  /* Adjust the font size as needed */
}


</style>
<!-- persuratan.php -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Surat Keluar</h1>

    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Surat Keluar</h6>
                <!-- Tulis Surat Keluar Button placed beside the title -->
                <?php if (session()->get('level') == 2||session()->get('level') == 4): ?>   
                <button class="btn btn-success" data-toggle="modal" data-target="#tulisSuratKeluarModal">+ Tulis Surat Keluar</button>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <!-- Priority Filter Dropdown -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <select id="priorityFilter" class="form-control">
                            <option value="">All Priorities</option>
                            <option value="Biasa">Biasa</option>
                            <option value="Segera">Segera</option>
                            <option value="Sangat Segera">Sangat Segera</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button id="filterButton" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Penerima</th>
                                <th>Perihal</th>
                                <th>Isi surat</th>
                                <th>Prioritas</th>
                                <th>Tanggal Surat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jel)) { ?>
                                <?php foreach($jel as $surat): ?>
                                    <tr class="surat-row" data-prioritas="<?= $surat->prioritas ?>">
                                        <td class="small-text"><?= $surat->penerima ?></td>
                                        <td class="small-text" title="<?= htmlspecialchars($surat->perihal, ENT_QUOTES, 'UTF-8') ?>">
                                            <?= strlen($surat->perihal) > 45 ? substr($surat->perihal, 0, 45) . '...' : $surat->perihal ?>
                                        </td>
                                        <td class="small-text" title="<?= htmlspecialchars($surat->isi_surat, ENT_QUOTES, 'UTF-8') ?>">
                                            <?= strlen($surat->isi_surat) > 45 ? substr($surat->isi_surat, 0, 45) . '...' : $surat->isi_surat ?>
                                        </td>
                                        <td>
                                            <?php if ($surat->prioritas == "Biasa"): ?>
                                                <span class="badge badge-info">
                                                    <i class="fas fa-circle"></i> Biasa
                                                </span>
                                            <?php elseif ($surat->prioritas == "Segera"): ?>
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-exclamation-circle"></i> Segera
                                                </span>
                                            <?php elseif ($surat->prioritas == "Sangat Segera"): ?>
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Sangat Segera
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-light">Unknown</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small-text"><?= $surat->tanggal_surat ?></td>
                                        <td>
                                            
                                            <a href="<?= base_url('home/generatePdf/' . $surat->id_surat) ?>" 
                                               class="btn btn-danger btn-sm">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                            <!-- Delete Button with Trash Icon -->
                                            <?php if (session()->get('level') == 2||session()->get('level') == 4): ?>
                                            <a href="<?= base_url('home/h_suratk/' . $surat->id_surat) ?>" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a><?php endif; ?>
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


<!-- Modal for Tulis Surat Masuk -->
<div class="modal fade" id="tulisSuratMasukModal" tabindex="-1" aria-labelledby="tulisSuratMasukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Set modal-lg for wider view -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tulisSuratMasukLabel"><i class="fas fa-file-alt mr-2" id="file_icon"></i>Tambah Surat Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('home/t_suratm') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- General Information Section -->
                    <h6 class="font-weight-bold">Informasi Umum</h6>
                    <p class="text-muted">Lengkapi informasi pada surat masuk.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nomor_surat">No. Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tgl_surat">Tgl. Surat</label>
                            <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" required>
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="instansi_pengirim">Instansi Pengirim</label>
                            <input type="text" class="form-control" id="instansi_pengirim" name="pengirim" required>
                        </div>
                    
                    <div class="form-group">
                        <label for="perihal">Perihal Surat</label>
                        <input type="text" class="form-control" id="perihal" name="perihal" required>
                    </div>

                    <!-- Additional Information Section -->
                    <h6 class="font-weight-bold mt-4">Informasi Tambahan</h6>
                    <p class="text-muted">Silahkan lengkapi jumlah lampiran, status, dan sifat tindakan surat!</p>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="lampiran">Lampiran</label>
                            <select class="form-control" id="lampiran" name="lampiran" required>
                                 <option value="Lampiran 1">Lampiran 1</option>
                                 <option value="Lampiran 2">Lampiran 2</option>
                                 <option value="Lampiran 3">Lampiran 3</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Asli">Asli</option>
                                <option value="Tembusan">Tembusan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="prioritas">Prioritas</label>
                            <select class="form-control" id="prioritas" name="prioritas" required>
                                <option value="Biasa">Biasa</option>
                                <option value="Segera">Segera</option>
                                <option value="Sangat Segera">Sangat Segera</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kategori and Sub-Kategori Section -->
                    <h6 class="font-weight-bold mt-4">Kategori dan Sub-Kategori</h6>
                    <p class="text-muted">Pilih kategori dan sub-kategori yang sesuai.</p>
                    <div class="form-row">
                        <!-- Kategori Dropdown -->
                        <div class="form-group col-md-6">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori" required onchange="updateSubKategori()">
                                <option value="">Pilih Kategori</option>
                                <option value="HRD">HRD</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Kesiswaan">Kesiswaan</option>
                            </select>
                        </div>
                        <!-- Sub-Kategori Dropdown -->
                        <div class="form-group col-md-6">
                            <label for="sub_kategori">Sub-Kategori</label>
                            <select class="form-control" id="sub_kategori" name="sub_kategori" required>
                                <!-- Default Option -->
                                <option value="">Pilih Sub-Kategori</option>
                                <option class="kesiswaan-option" value="Jadwal Sekolah">Jadwal Sekolah</option>
                                <option class="kesiswaan-option" value="Pengambilan Raport">Pengambilan Raport</option>
                                <option class="kesiswaan-option" value="Pengambilan Ijazah">Pengambilan Ijazah</option>
                                <option class="admin-option" value="Pembayaran">Pembayaran</option>
                                <option class="hrd-option" value="Pengajuan Cuti">Pengajuan Cuti</option>
                                <option class="hrd-option" value="Izin Terlambat">Izin Terlambat</option>
                                <option class="hrd-option" value="Lamaran Kerja Karyawan">Lamaran Kerja Karyawan</option>
                            </select>
                        </div>

                    </div>

                    <!-- File Upload Section -->
                    <div class="form-group">
                        <label for="upload_file_keluar">Upload File</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control-file d-none" id="upload_file_keluar" name="foto" accept=".pdf,.doc,.docx,.jpg,.png" onchange="updateFileName(this)">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('upload_file_keluar').click()">Choose File</button>
                            <span id="file_name" class="ml-2 text-muted">No file chosen</span>
                        </div>
                        <small class="form-text text-muted">* Semua file type diizinkan</small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Tulis Surat Keluar -->
<div class="modal fade" id="tulisSuratKeluarModal" tabindex="-1" aria-labelledby="tulisSuratKeluarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tulisSuratKeluarLabel"><i class="fas fa-file-alt mr-2" id="file_icon"></i>Tambah Surat Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('home/t_suratk') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- General Information Section -->
                    <h6 class="font-weight-bold">Informasi Umum</h6>
                    <p class="text-muted">Lengkapi informasi pada surat keluar.</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nomor_surat_keluar">No. Surat</label>
                            <input type="text" class="form-control" id="nomor_surat_keluar" name="nomor_surat" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tgl_surat_keluar">Tgl. Surat</label>
                            <input type="date" class="form-control" id="tgl_surat_keluar" name="tgl_surat" required>
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="penerima_keluar">Penerima</label>
                        <input type="text" class="form-control" id="penerima_keluar" name="penerima" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pengirim_keluar">Pengirim</label>
                        <input type="text" class="form-control" id="pengirim_keluar" name="pengirim" required>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="perihal_keluar">Perihal Surat</label>
                        <input type="text" class="form-control" id="perihal_keluar" name="perihal" required>
                    </div>
                    <div class="form-group">
                        <label for="isi_surat_keluar">Isi Surat</label>
                        <textarea class="form-control" id="isi_surat_keluar" name="isi_surat" rows="3" required></textarea>
                    </div>

                    <!-- Additional Information Section -->
                    <h6 class="font-weight-bold mt-4">Informasi Tambahan</h6>
                    <p class="text-muted">Pilih sifat prioritas surat.</p>
                    <div class="form-group">
                        <label for="prioritas_keluar">Prioritas</label>
                        <select class="form-control" id="prioritas_keluar" name="prioritas" required>
                            <option value="Biasa">Biasa</option>
                            <option value="Segera">Segera</option>
                            <option value="Sangat Segera">Sangat Segera</option>
                        </select>
                    </div>

                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


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







<!-- Include this CSS for custom styling -->
<style>
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
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        font-weight: 500;
    }
    .btn-primary:hover, .btn-secondary:hover {
        opacity: 0.85;
    }
    
    /* Footer buttons */
    .modal-footer .btn {
        width: 100px;
    }
</style>


<!-- Modal for Confirmation of Deletion -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus surat ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="h_suratk" id="deleteConfirmButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Set the ID of the row to be deleted
    $('.delete-button').on('click', function() {
        var suratId = $(this).data('id_surat'); // Get the id_surat from the data-id_surat attribute
        $('#deleteConfirmButton').attr('href', '<?= base_url('home/deleteSurat/') ?>' + suratId); // Set the href to the delete URL
    });
</script>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<!-- Bootstrap and jQuery JS (required for Bootstrap 4 modals) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    $('#ajukanModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    
    // Extract data from data-* attributes
    var idSurat = button.data('id_surat'); // Corrected here, as you need to use 'id' instead of 'id_surat'
    var status = button.data('status');
    var status1 = button.data('status1');
    var prioritas = button.data('prioritas');
    var agenda = button.data('agenda');
    var tanggal = button.data('tanggal');
    var noSurat = button.data('no_surat');
    var instansi = button.data('instansi');
    var perihal = button.data('perihal');
    var tanggalSurat = button.data('tanggal_surat');
    var lampiran = button.data('lampiran');
    
    // Update modal content
    var modal = $(this);
    modal.find('#modalStatus').text(status || 'N/A');
    modal.find('#modalStatus1').text(status1 || 'N/A');
    modal.find('#modalPrioritas').text(prioritas || 'N/A');
    modal.find('#modalAgenda').text(agenda || 'N/A');
    modal.find('#modalTanggal').text(tanggal || 'N/A');
    modal.find('#modalNoSurat').text(noSurat || 'N/A');
    modal.find('#modalInstansi').text(instansi || 'N/A');
    modal.find('#modalPerihal').text(perihal || 'N/A');
    modal.find('#modalTanggalSurat').text(tanggalSurat || 'N/A');
    modal.find('#modalLampiran').text(lampiran || 'N/A');
    
    // Set the id_surat value in the hidden input
    modal.find('#id_surat').val(idSurat);  // Corrected here to match your hidden field ID
});

</script>



<script>
    // JavaScript to filter table rows based on selected priority
    $(document).ready(function() {
        $('#filterButton').click(function() {
            var selectedPriority = $('#priorityFilter').val();
            $('.surat-row').each(function() {
                var rowPriority = $(this).data('prioritas');
                if (selectedPriority === "" || rowPriority === selectedPriority) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
