<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        /* Gradient Background */
        body.bg-gradient-primary {
            background: linear-gradient(135deg, #f5a6b5, #a0d8ef, #b8e5d3);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        /* Card Container */
        .card {
            max-width: 800px; /* Set a max width for the card */
            width: 100%;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        .card-body {
            padding: 3rem;
        }

        /* Split form columns */
        .form-row {
            margin-bottom: 1rem;
        }

        .form-column {
            padding: 0 15px;
        }

        .form-column input,
        .form-column select,
        .form-column textarea {
            font-size: 14px;
        }

        .btn-primary {
            border-radius: 0.35rem;
        }

        .login-form__btn {
            margin-top: 1rem;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .text-center h1 {
            font-size: 24px;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-size: 16px;
        }

        /* Style adjustments for inputs */
        .form-control {
            border-radius: 0.35rem;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="<?= base_url('home/aksi_t_register') ?>" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-6 form-column">
                                        <div class="form-group">
                                            <label for="yourUsername">Username</label>
                                            <input type="text" class="form-control form-control-user" id="yourUsername" name="nama" placeholder="Your name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-column">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Your email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-column">
                                        <div class="form-group">
                                            <label for="nama_asli">Nama Asli</label>
                                            <input type="text" class="form-control form-control-user" id="nama_asli" name="nama_asli" placeholder="Your full name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-column">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control form-control-user" id="alamat" name="alamat" placeholder="Your address" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 form-column">
                                        <div class="form-group">
                                            <label for="pass">Password</label>
                                            <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100" type="submit">Create an account</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('home/login') ?>">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>
