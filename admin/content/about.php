<?php
 $query = mysqli_query($koneksi, "SELECT * FROM about ORDER BY id ASC");
 $rows   = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

        <div class="pagetitle">
          <h1>Data Tentang Kami</h1>
        </div><!-- End Page Title -->
    
        <section class="section">
            <div class="row">
                   <div class="col-lg-12">
                     <div class="card">
                       <div class="card-body">
                         <h5 class="card-title">Data Tentang Kami </h5>

                         <div class="mb-3" align="right">
                            <a href="?page=tambah-about" class="btn btn-primary">Tambah</a>
                         </div>
                         <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Status</th>
                                  </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $key => $row): ?>
                                <tr>
                                    <td><?php echo $key += 1 ?></td>
                                    <td><img src="uploads/<?php echo $row['image']?>" alt="" width="100"></td>
                                    <td><?php echo $row['title']?></td>
                                    <td><?php echo $row['content']?></td>
                                    <td><?php echo $row['is_active']?></td>
                                    <td>
                                        <a href="?page=tambah-about&edit=<?php echo $row['id'] ?>" class="btn btn-sm btn-success">
                                            Edit
                                        </a>
                                        <a
                                        onclick="return confirm ('Apakah anda yakin akan menghapus data ini??')"
                                        href="?page=tambah-about&delete=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                         </table>
                       </div>
                     </div>
                   </div>
            </div>
        </section>
    