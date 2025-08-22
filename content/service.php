    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
    
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
            <?php foreach($rowServices as $rs):?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                    <div class="icon">
                        <img src="admin/uploads/services/<?= $rs['icon']?>" alt="" width="50">
                    </div>
                    <a href="#" class="stretched-link">
                        <h3><?=$rs['title']?></h3>
                    </a>
                    <p><?=$rs['description']?></p>
                    </div>
                </div><!-- End Service Item -->
            <?php endforeach?>


        </div>

      </div>

    </section><!-- /Services Section -->
