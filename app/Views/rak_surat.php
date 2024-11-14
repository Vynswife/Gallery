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

</style><!-- album_list.php -->
<div class="container">
    <h2 class="my-4">Photo Gallery Albums</h2>
    <div class="row">
        <?php if (!empty($albums)): ?>
            <?php foreach ($albums as $album): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= base_url('img/' . $album->foto_album) ?>" class="card-img-top img-thumbnail" alt="<?= $album->nama_album ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $album->nama_album ?></h5>
                            <p class="card-text"><?= $album->deskripsi ?></p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photoModal<?= $album->id_album ?>">
                                View Album
                            </button>
                        </div>
                    </div>
                </div>

               <!-- Modal Structure -->
<div class="modal fade" id="photoModal<?= $album->id_album ?>" tabindex="-1" aria-labelledby="photoModalLabel<?= $album->id_album ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel<?= $album->id_album ?>">Album: <?= $album->nama_album ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Photos:</h6>
                
                <?php if (!empty($album->photos)): ?>
                    <?php foreach ($album->photos as $photo): ?>
                        <div class="mb-4">
                            <!-- Display the photo image -->
                            <img src="<?= base_url('img/' . $photo->lokasi) ?>" alt="<?= $photo->judul ?>" style="width: 100%;" class="img-thumbnail mb-2">
                            
                            <!-- Display photo details -->
                            <p><strong>Judul:</strong> <?= $photo->judul ?></p>
                            <p><strong>Deskripsi:</strong> <?= $photo->deskripsi ?></p>
                            <p><strong>Tanggal Upload:</strong> <?= $photo->tanggal_buat ?></p>
                            <p><strong>Uploader:</strong> <?= $photo->username ?></p>
                            
                            <!-- Like Button with Count -->
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Display total likes for this photo -->
                                <p><strong>Likes:</strong> <?= $likes ?> <i class="bi bi-heart-fill text-danger"></i></p>

                                <!-- Like Button Form -->
                                <form action="<?= base_url('home/like') ?>" method="POST">
                                    <input type="hidden" name="id_foto" value="<?= $photo->id_foto ?>">
                                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
                                        <i class="bi bi-heart"></i> Like
                                    </button>
                                </form>

                                <!-- Comment Button (this will expand the comments section) -->
                                <button class="btn btn-outline-info" data-bs-toggle="collapse" data-bs-target="#commentsSection<?= $photo->id_foto ?>" aria-expanded="false" aria-controls="commentsSection<?= $photo->id_foto ?>">
                                    <i class="bi bi-chat-left-text"></i> Comment
                                </button>
                            </div>

                            <!-- Comments Section (this will collapse when not clicked) -->
                            <div class="collapse mt-3" id="commentsSection<?= $photo->id_foto ?>">

                                <!-- Display existing comments -->
                                <h6>Comments:</h6>
                                <?php if (!empty($photo->comments)): ?>
                                    <?php foreach ($photo->comments as $comment): ?>
                                        <div class="mb-2">
                                            <p><strong><?= $comment->username ?>:</strong> <?= $comment->isi_komen ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No comments yet.</p>
                                <?php endif; ?>

                                <!-- Comment Form -->
                                <form action="<?= base_url('home/comment') ?>" method="POST">
                                    <input type="hidden" name="id_foto" value="<?= $photo->id_foto ?>">
                                    <textarea name="comment_text" class="form-control" rows="3" placeholder="Write a comment..."></textarea>
                                    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                                </form>

                            </div> <!-- End of Collapse -->

                        </div>
                        <hr> <!-- Optional divider between photos -->
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No photos available for this album.</p>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>



            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">No albums available.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).on('click', '.like-button', function() {
        const idFoto = $(this).data('id_foto');
        
        $.ajax({
            url: '<?= base_url("home/like") ?>',
            type: 'POST',
            data: { id_foto: idFoto },
            success: function(response) {
                if (response.success) {
                    // Update like count
                    const likeCount = response.like_count;
                    $('#like-count-' + idFoto).text(likeCount);
                } else {
                    alert(response.message || "An error occurred.");
                }
            },
            error: function() {
                alert("Unable to process like at this moment.");
            }
        });
    });
</script>

    

<script>
    $(document).ready(function () {
        // Trigger the modal when the View Album button is clicked
        $('#photoModal').on('show.bs.modal', function (event) {
            // Get the button that triggered the modal
            var button = $(event.relatedTarget);

            // Retrieve data from the button's data-* attributes
            var albumId = button.data('id');
            var albumTitle = button.closest('.card-body').find('.card-title').text();
            var albumDescription = button.closest('.card-body').find('.card-text').text();
            var albumImage = button.closest('.card').find('img').attr('src');

            // Populate the modal with the album details
            var modal = $(this);
            modal.find('#id_foto').val(albumId);
            modal.find('#photoTitle').text(albumTitle);
            modal.find('#photoDescription').text(albumDescription);
            modal.find('#photoImage').attr('src', albumImage);

            // Optionally, you could add Date Created and Location if you have this data
            // modal.find('#photoDate').text(albumDate);
            // modal.find('#photoLocation').text(albumLocation);
        });
    });
</script>


<script>
    // JavaScript to dynamically populate modal content
    document.addEventListener('DOMContentLoaded', function() {
        $('#photoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var photoId = button.data('id');
            var photoTitle = button.data('judul');
            var photoDescription = button.data('deskripsi');
            var photoDate = button.data('tanggal');
            var photoLocation = button.data('lokasi');
            var photoImageUrl = button.data('image');

            // Populate the modal with the data attributes
            var modal = $(this);
            modal.find('#id_foto').val(photoId);
            modal.find('#photoTitle').text(photoTitle);
            modal.find('#photoDescription').text(photoDescription);
            modal.find('#photoDate').text(photoDate);
            modal.find('#photoLocation').text(photoLocation);
            modal.find('#photoImage').attr('src', photoImageUrl);
        });
    });
</script>



<script>
    // JavaScript to fetch images based on the album clicked
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);  // Button that triggered the modal
        var albumId = button.data('id');  // Extract album ID
        
        // Use AJAX to fetch the images for the selected album
        $.ajax({
            url: "<?= base_url('home/view_album') ?>/" + albumId,  // Pass album ID to controller
            type: "GET",
            success: function (response) {
                var photos = JSON.parse(response);  // Assuming JSON response with photos
                var imageContainer = $('#imageContainer');
                imageContainer.empty();  // Clear previous images
                
                // Add each image to the modal
                photos.forEach(function(photo) {
                    imageContainer.append(`
                        <div class="col-md-3 mb-4">
                            <img src="<?= base_url('img/photos/') ?>${photo.foto_album}" class="img-fluid" alt="${photo.judul}">
                            <p>${photo.judul}</p>
                        </div>
                    `);
                });
            }
        });
    });
</script>






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


<!-- Enhanced Modal Structure -->
<div class="modal fade" id="ajukanModal" tabindex="-1" aria-labelledby="ajukanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('home/e_ajuansuratm'); ?>" method="post"> <!-- Update 'controller_name' with your actual controller name -->
                <div class="modal-header">
                    <h5 class="modal-title" id="ajukanModalLabel">Detail Surat Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
<div class="modal-body">
    <!-- Nomor Agenda and Status Surat Sections Side by Side -->
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <h6>Pengirim Surat: <span id="modalPengirim">N/A</span></h6>
                <p><strong>Berkas:</strong> <span id="modalStatus">N/A</span></p>
                <p><strong>Prioritas:</strong> <span id="modalPrioritas">N/A</span></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h6>Status Surat</h6>
                <p><strong>Status:</strong> <span id="modalStatus1">N/A</span></p>
            </div>
        </div>
    </div>

    <!-- Informasi Detail Surat Section -->
    <div class="card mt-3 p-3">
        <h6>Informasi Detail Surat</h6>
        <table class="table table-borderless">
            <tr>
                <td><strong>No. Surat</strong></td>
                <td><span id="modalNoSurat">N/A</span></td>
            </tr>
            <tr>
                <td><strong>Perihal</strong></td>
                <td><span id="modalPerihal">N/A</span></td>
            </tr>
            <tr>
                <td><strong>Tanggal Surat</strong></td>
                <td><span id="modalTanggalSurat">N/A</span></td>
            </tr>
            <tr>
                <td><strong>Lampiran</strong></td>
                <td><span id="modalLampiran">N/A</span></td>
            </tr>
        </table>
    </div>

    
</div>

<!-- Hidden input for Surat ID -->
<input type="hidden" name="id_surat" id="id_surat" value="<?= $surat->id_surat ?>">

<!-- Modal Footer -->
<div class="modal-footer">

    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
        var idSurat = button.data('id_surat');
        var status = button.data('status');
        var status1 = button.data('status1');
        var prioritas = button.data('prioritas');
        var tanggal = button.data('tanggal');
        var noSurat = button.data('no_surat');
        var instansi = button.data('instansi');
        var perihal = button.data('perihal');
        var tanggalSurat = button.data('tanggal_surat');
        var lampiran = button.data('lampiran');
        var pengirim = button.data('pengirim');
        
        // Update modal content
        var modal = $(this);
        modal.find('#modalStatus').text(status || 'N/A');
        modal.find('#modalStatus1').text(status1 || 'N/A');
        modal.find('#modalPrioritas').text(prioritas || 'N/A');
        modal.find('#modalTanggal').text(tanggal || 'N/A');
        modal.find('#modalNoSurat').text(noSurat || 'N/A');
        modal.find('#modalInstansi').text(instansi || 'N/A');
        modal.find('#modalPerihal').text(perihal || 'N/A');
        modal.find('#modalTanggalSurat').text(tanggalSurat || 'N/A');
        modal.find('#modalLampiran').text(lampiran || 'N/A');
        modal.find('#modalPengirim').text(pengirim || 'N/A');
        
        // Set the id_surat value in the hidden input
        modal.find('#id_surat').val(idSurat);
        
        // Check the status and enable/disable the 'Update Data' button accordingly
        if (status1 === "Diajukan") {
            // If status is "Diajukan", disable the "Update Data" button
            modal.find('#updateButton').prop('disabled', true);
        } else {
            // If status is not "Diajukan", enable the "Update Data" button
            modal.find('#updateButton').prop('disabled', false);
        }
    });
</script>


<script>
    // JavaScript to filter table rows based on selected sub_kategori
    $(document).ready(function() {
        $('#filterButton').click(function() {
            var selectedSubKategori = $('#subKategoriFilter').val();
            $('.surat-row').each(function() {
                var rowSubKategori = $(this).data('sub_kategori');
                if (selectedSubKategori === "" || rowSubKategori === selectedSubKategori) {
                    $(this).show(); // Show the row if it matches the selected sub-kategori or if "All Sub-Categories" is selected
                } else {
                    $(this).hide(); // Hide the row if it doesn't match
                }
            });
        });
    });
</script>
