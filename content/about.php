<?php
//keahlan
$querySkills = mysqli_query($koneksi, "SELECT skills.* FROM skills JOIN users ON users.id = skills.id_user");
$rowSkills = mysqli_fetch_all($querySkills, MYSQLI_ASSOC);
//fakta
$queryFacts = mysqli_query($koneksi, "SELECT facts.* FROM facts JOIN users ON users.id = facts.id_user");
$rowFacts = mysqli_fetch_all($queryFacts, MYSQLI_ASSOC);
//penilaian
$queryTestimotials = mysqli_query($koneksi, "SELECT testimotials.* FROM testimotials JOIN users ON users.id = testimotials.id_user");
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
            <div class="col-lg-8 content">
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

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Clients</p>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Projects</p>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Hours Of Support</p>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Workers</p>
                </div>
            </div><!-- End Stats Item -->

        </div>

    </div>

</section><!-- /Stats Section -->

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
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

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                        <h3>Saul Goodman</h3>
                        <h4>Ceo &amp; Founder</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                        <h3>Sara Wilsson</h3>
                        <h4>Designer</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                        <h3>Jena Karlis</h3>
                        <h4>Store Owner</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                        <h3>Matt Brandon</h3>
                        <h4>Freelancer</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                        <h3>John Larson</h3>
                        <h4>Entrepreneur</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                    </div>
                </div><!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Testimonials Section -->