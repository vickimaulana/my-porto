<?php
//  jika data setting sudah ada maka update data tersebut
// selain itu kalo blm ada maka insert data
$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$row = mysqli_fetch_assoc($querySetting);

function uploadImage($file, $row = [], $field = 'logo', $uploadDir = "uploads/")
{
    // Pastikan ada file yang diupload
    if (!empty($file['name'])) {
        // Buat folder kalau belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Buat nama unik (timestamp + nama asli)
        $fileName   = time() . "-" . basename($file['name']);
        $targetFile = $uploadDir . $fileName;

        // Upload file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Hapus file lama kalau ada
            if (!empty($row[$field]) && file_exists($uploadDir . $row[$field])) {
                unlink($uploadDir . $row[$field]);
            }

            return $fileName; // kembalikan nama file baru
        }
    }

    return $row[$field] ?? null; // kalau tidak upload, pakai nama lama
}


if (isset($_POST['simpan'])) {
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];
    $ig       = $_POST['instagram'];
    $fb       = $_POST['facebook'];
    $twitter  = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];

    // Gunakan fungsi upload
    $logo_name = uploadImage($_FILES['logo'], $row, 'logo');
    $image_bg  = uploadImage($_FILES['image'], $row, 'image');

    if ($row) {
        // update
        $id_setting = $row['id'];
        $update = mysqli_query($koneksi, "UPDATE settings 
                    SET email='$email', 
                        phone='$phone', 
                        logo='$logo_name', 
                        image='$image_bg', 
                        address='$address', 
                        ig='$ig', 
                        fb='$fb', 
                        twitter='$twitter', 
                        linkedin='$linkedin' 
                    WHERE id='$id_setting'");
        if ($update) {
            header("location:?page=setting&ubah=berhasil");
            exit;
        }
    } else {
        // insert
        $insert = mysqli_query($koneksi, "INSERT INTO settings 
                (email, phone, logo, image, address, ig, fb, twitter, linkedin) 
                VALUES 
                ('$email','$phone','$logo_name','$image_bg','$address','$ig','$fb','$twitter','$linkedin')");
        if ($insert) {
            header("location:?page=setting&tambah=berhasil");
            exit;
        }
    }
}
?>


<div class="pagetitle">
    <h1>Pengaturan</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengaturan</h5>
                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Email -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Email</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="email" name="email" id="" class="form-control" value="<?php echo isset($row['email']) ? $row['email'] : '' ?>">
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">No Telp</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="number" name="phone" id="" class="form-control" value="<?php echo isset($row['phone']) ? $row['phone'] : '' ?>">
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Alamat</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea name="address" id="" class="form-control"><?php echo isset($row['address']) ? $row['address'] : '' ?></textarea>
                            </div>
                        </div>
                        <!-- Logo -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Logo</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="file" name="logo"><img class='mt-2' src="uploads/<?php echo isset($row['logo']) ? $row['logo'] : '' ?>" alt="logo" width="100" class="form-control">
                            </div>
                        </div>
                         <!-- Background Image -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Background Image</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="file" name="image"><img class='mt-2' src="uploads/<?php echo isset($row['image']) ? $row['image'] : '' ?>" alt="bg-image" width="100" class="form-control">
                            </div>
                        </div>
                        <!-- Twitter -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Twitter</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="twitter" id="" class="form-control" value="<?php echo isset($row['twitter']) ? $row['twitter'] : '' ?>">
                            </div>
                        </div>
                        <!-- Facebook -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Facebook</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="facebook" id="" class="form-control" value="<?php echo isset($row['fb']) ? $row['fb'] : '' ?>">
                            </div>
                        </div>
                        <!-- Instagram -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Instagram</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="instagram" id="" class="form-control" value="<?php echo isset($row['ig']) ? $row['ig'] : '' ?>">
                            </div>
                        </div>
                        <!-- LinkedIn -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">LinkedIn</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="linkedin" id="" class="form-control" value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : '' ?>">
                            </div>
                        </div>
                        <!-- tombol simpan -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <button class="btn btn-primary" name="simpan">Simpan</button>
                                <a href="?page=setting" class="text-muted">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>