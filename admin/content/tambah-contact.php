<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM contact WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title = "Edit Contact";
} else {
    $title = "Tambah Contact";
}
//query untuk menghapus user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM contact WHERE id='$id'");
    if ($delete) {
        header("location:?page=contact&tambah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $description = $_POST['description'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $type = mime_content_type($tmp_name);
        $path = "uploads/";


        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];
        if (in_array($type, $ext_allowed)) {
            if (!is_dir($path))
                mkdir($path); //mkdir itu untuk memebuat folder jika belum ada //is_dir itu untuk mengecek apakah folder sudah ada atau belum
            $image_name = time() . "-" . basename($image);
            $target_files = $path . $image_name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_files)) {
                //jika gambarnya ada maka gambar sebelumnya akan di ganti oleh gambar baru
                if (!empty($row['image'])) {
                    unlink($path . $row['image']); //unlink untuk menghapus file

                }
            }
        } else {
            echo "ekstitensi tidak ditemukan";
            die();
        }
    }

    //ini query update
    if ($id) {

        $update = mysqli_query($koneksi, "UPDATE contact SET phone='$phone', description='$description', address='$address', email='$email' WHERE id='$id'");
        if ($update) {
            header("location:?page=contact&ubah=berhasil");
        }
    } else {

        $insert = mysqli_query($koneksi, "INSERT INTO contact (phone, description, address,email)
        VALUES('$phone', '$description', '$address', '$email')");
        if ($insert) {
            header("location:?page=contact&tambah=berhasil");
        }
    }
}

?>


<div class="pagetitle">
    <h1><?php echo $title ?></h1>

</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $title ?></h5>
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="">Description</label>
                            <textarea name="description" id="summernote"
                                class="form-control"><?php echo ($id) ? $rowEdit['description'] : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="url" name="address" class="form-control"
                                placeholder="Tempel link dari Google Maps" required value="<?php echo ($id) ? $rowEdit['address'] : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" placeholder="Masukkan No Telp"
                                required value="<?php echo ($id) ? $rowEdit['phone'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Masukkan Alamat Email"
                                required value="<?php echo ($id) ? $rowEdit['email'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=user" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>

</section>