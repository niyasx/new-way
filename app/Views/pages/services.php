<?php

declare(strict_types=1);

use App\Helpers\ComponentLoader;
?>
<div class="page-hero">
  <div class="wrap">
    <span class="eyebrow">What We Offer</span>
    <h1 class="section-title">Our <em>Services</em></h1>
    <div class="section-rule"></div>
  </div>
</div>
<?php
ComponentLoader::render('services');
ComponentLoader::render('industries');
ComponentLoader::render('cta-band');
