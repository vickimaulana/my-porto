<?php
//query untuk edit 
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if ($id) {
    $query   = mysqli_query($koneksi, "SELECT * FROM contacts WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);
    $title   = "Edit Contact";
} else {
    $title   = "Tambah Contact";
}

//query untuk menghapus contact
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM contacts WHERE id='$id'");
    if ($delete) {
        header("location:?page=contact&hapus=berhasil");
        exit;
    }
}

// Proses simpan data
if (isset($_POST['simpan'])) {
    $description = $_POST['description'];
    $address     = $_POST['address'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $map_embed   = $_POST['map_embed'];

    if ($id) {
        // update
        $update = mysqli_query($koneksi, "UPDATE contacts 
            SET description='$description', address='$address', phone='$phone', email='$email', map_embed='$map_embed'
            WHERE id='$id'");
        if ($update) {
            header("location:?page=contact&ubah=berhasil");
            exit;
        }
    } else {
        // insert
        $insert = mysqli_query($koneksi, "INSERT INTO contacts (description, address, phone, email, map_embed) 
            VALUES ('$description', '$address', '$phone', '$email', '$map_embed')");
        if ($insert) {
            header("location:?page=contact&tambah=berhasil");
            exit;
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

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Description</label>
                            <textarea name="description" id="summernote"
                                class="form-control"><?php echo ($id) ? $rowEdit['description'] : '' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control"
                                placeholder="Masukkan alamat" required
                                value="<?php echo ($id) ? $rowEdit['address'] : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="map_embed">Google Maps Embed (iframe)</label>
                            <textarea name="map_embed" rows="4" class="form-control"
                                placeholder="Tempel kode iframe dari Google Maps"><?php echo ($id) ? $rowEdit['map_embed'] : '' ?></textarea>
                        </div>

                        <?php if (!empty($rowEdit['map_embed'])): ?>
                            <div class="mt-3">
                                <label>Preview Map:</label>
                                <div style="border:1px solid #ddd; border-radius:8px; overflow:hidden;">
                                    <?= $rowEdit['map_embed'] ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" placeholder="Masukkan No Telp"
                                required value="<?php echo ($id) ? $rowEdit['phone'] : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Alamat Email"
                                required value="<?php echo ($id) ? $rowEdit['email'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">💾 Simpan</button>
                            <a href="?page=contact" class="btn btn-secondary">↩ Kembali</a>
                        </div>