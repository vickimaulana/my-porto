<?php
//  jika data setting sudah ada maka update data tersebut
// selain itu kalo blm ada maka insert data
$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$row = mysqli_fetch_assoc($querySetting);

if(isset($_POST['simpan'])){
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $ig = $_POST['instagram'];
    $fb = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $linkedin = $_POST['linkedin'];

// jika gambar terupload
if(!empty($_FILES['logo']['name'])){
    $logo = $_FILES['logo']['name'];
    $path = "uploads/";
    if(!is_dir($path)) mkdir($path);

    $logo_name = time() . "-" . basename($logo);
    $target_file = $path . $logo_name;
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file )){
        // jika gambarnya ada maka gambar sebelumnya akan diganti oleh gambar baru
        if(!empty($row['logo'])){
            unlink($path . $row['logo']);
        }
    }
}



    if ($row){
        // update
    
        $id_setting= $row['id'];
        $update = mysqli_query($koneksi, " UPDATE settings SET email='$email', phone='$phone', logo='$logo_name', address='$address', ig='$ig', fb='$fb', twitter='$twitter', linkedin='$linkedin' WHERE id='$id_setting'");
        if ($update){
            header("location:?page=setting&ubah=berhasil");
        }
    } else{
        //insert
        $insert = mysqli_query($koneksi, "INSERT INTO settings (email, phone, logo, address, ig, fb, twitter, linkedin)
        VALUES ('$email','$phone','$logo_name','$address','$ig','$fb', '$twitter', '$linkedin$')");
        if ($insert) { header("location:?page=setting&tambah=berhasil");
    }
}}
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
                                <input type="email" name="email" id="" class="form-control" value="<?php echo isset($row['email']) ? $row['email'] : ''?>">
                            </div>
                        </div>
                        <!-- Phone -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">No Telp</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="number" name="phone" id="" class="form-control" value="<?php echo isset($row['phone']) ? $row['phone'] : ''?>">
                            </div>
                        </div>
                        <!-- Address -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Alamat</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea name="address" id="" class="form-control"><?php echo isset($row['address']) ? $row['address'] : ''?></textarea>
                            </div>
                        </div>
                        <!-- Logo -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Logo</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="file" name="logo"><img class='mt-2' src="uploads/<?php echo isset($row['logo']) ? $row['logo'] : ''?>" alt="logo" width="100" class="form-control">
                            </div>
                        </div>
                        <!-- Twitter -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Twitter</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="twitter" id="" class="form-control" value="<?php echo isset($row['twitter']) ? $row['twitter'] : ''?>">
                            </div>
                        </div>
                        <!-- Facebook -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Facebook</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="facebook" id="" class="form-control" value="<?php echo isset($row['fb']) ? $row['fb'] : ''?>">
                            </div>
                        </div>
                        <!-- Instagram -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">Instagram</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="instagram" id="" class="form-control" value="<?php echo isset($row['ig']) ? $row['ig'] : ''?>">
                            </div>
                        </div>
                        <!-- LinkedIn -->
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="" class="form-label fw-bold">LinkedIn</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="linkedin" id="" class="form-control" value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : ''?>">
                            </div>
                        </div>
                        <!-- tombol simpan -->
                        <div class="mb-3 row">
                        <div class="col-sm-2">
                            <button  class="btn btn-primary" name="simpan">Simpan</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>