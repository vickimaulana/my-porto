<?php
//keahlian
$querySkills = mysqli_query($koneksi, "SELECT skills.* FROM skills JOIN users ON users.id = skills.id_user");
$rowSkills = mysqli_fetch_all($querySkills, MYSQLI_ASSOC);
//fakta
$queryFacts = mysqli_query($koneksi, "SELECT facts.* FROM facts");
$rowFacts = mysqli_fetch_all($queryFacts, MYSQLI_ASSOC);
//penilaian
$queryTestimotials = mysqli_query($koneksi, "SELECT * FROM testimonials");
$rowTestimotials = mysqli_fetch_all($queryTestimotials, MYSQLI_ASSOC);

// Bagi 2 kolom (misal untuk tampilan kiri-kanan)
$half = ceil(count($rowSkills) / 2);
$col1 = array_slice($rowSkills, 0, $half);
$col2 = array_slice($rowSkills, $half);
?>

<!-- About Section -->
<section id="about" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>About</h2>
        <p>Mengenal lebih tentang saya</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
            <div class="col-lg-4">
                <img src="admin/uploads/<?= $rowAbout['image'] ?>" class="img-fluid" alt="">
            </div>
            <div class="col-lg-8 content text-center justify-content">
                <h1><?= $rowAbout['name'] ?></h1>
                <h2><?= $rowAbout['title'] ?></h2>
                <p class="fst-italic py-3">
                    <?= $rowAbout['description'] ?>
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong> <span><?= date("d M Y", strtotime($rowAbout['birthday'])) ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span><?= $rowAbout['website'] ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong> <span><?= $rowAbout['phone'] ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span><?= $rowAbout['city'] ?></span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span><?= $rowAbout['age'] ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span><?= $rowAbout['degree'] ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span><?= $rowAbout['email'] ?></span></li>
                            <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong> <span><?= $rowAbout['freelance_status'] ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section><!-- /About Section -->

<!-- Skills Section -->
<section id="skills" class="skills section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Skills</h2>
        <p>Ini Keahlian Yang Saya Pelajari</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row skills-content skills-animation">

            <div class="col-lg-6">
                <?php foreach ($col1 as $skill): ?>
                    <div class="progress">
                        <span class="skill">
                            <span><?= htmlspecialchars($skill['name']) ?></span>
                            <i class="val"><?= (int)$skill['persentase'] ?>%</i>
                        </span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar"
                                role="progressbar"
                                aria-valuenow="<?= (int)$skill['persentase'] ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->
                <?php endforeach; ?>
            </div>

            <div class="col-lg-6">
                <?php foreach ($col2 as $skill): ?>
                    <div class="progress">
                        <span class="skill">
                            <span><?= htmlspecialchars($skill['name']) ?></span>
                            <i class="val"><?= (int)$skill['persentase'] ?>%</i>
                        </span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar"
                                role="progressbar"
                                aria-valuenow="<?= (int)$skill['persentase'] ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</section><!-- /Skills Section -->

<!-- Stats Section -->
<section id="stats" class="stats section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Facts</h2>
        <p>Jumlah Total Yang Sudah dikerjakan</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

                <?php foreach($rowFacts as $val): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $val['stat_value'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p><?= $val['stat_name'] ?></p>
                    </div>
                </div><!-- End Stats Item -->
                <?php endforeach?>
        </div>

    </div>

</section><!-- /Stats Section -->

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Beberapa Penilaian Dari Seseorang</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    }
                }
            </script>
            <div class="swiper-wrapper">

                <?php foreach($rowTestimotials as $val): ?>
                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="admin/uploads/<?= $val['image']?>" class="testimonial-img" alt="">
                        <h3><?= $val['name']?></h3>
                        <h4><?= $val['position']?></h4>
                        <div class="stars">
                            <?php 
                                $rating = (int) $val['rating']; // pastikan integer
                                $maxStars = 5;

                                // Bintang terisi
                                for ($i = 0; $i < $rating; $i++) {
                                    echo '<i class="bi bi-star-fill"></i>';
                                }

                                // Bintang kosong
                                for ($i = $rating; $i < $maxStars; $i++) {
                                    echo '<i class="bi bi-star"></i>';
                                }
                            ?>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span><?= $val['message']?></span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->
                <?php endforeach?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Testimonials Section -->