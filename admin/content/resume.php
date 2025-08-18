<?php
$query = mysqli_query($koneksi, "SELECT * FROM resumes ORDER BY id ASC");
$rows  = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<div class="pagetitle">
    <h1>Data Resume</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Resume</h5>

                    <div class="mb-3 text-end">
                        <a href="?page=tambah-resume" class="btn btn-primary">Tambah</a>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Institution</th>
                                <th>Start Year</th>
                                <th>End Year</th>
                                <th>Credential</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= ucfirst($row['type']) ?></td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['subtitle'] ?></td>
                                    <td><?= $row['institution'] ?></td>
                                    <td><?= $row['start_year'] ?></td>
                                    <td><?= $row['end_year'] ?: 'Present' ?></td>
                                    <td>
                                        <?php if (!empty($row['link'])): ?>
                                            <a href="<?= $row['link'] ?>" target="_blank">Lihat</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?page=tambah-resume&edit=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
                                        <a href="?page=tambah-resume&delete=<?= $row['id'] ?>"
                                            onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                            class="btn btn-sm btn-danger">
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