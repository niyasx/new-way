<?php

declare(strict_types=1);

use App\Helpers\ComponentLoader;
?>
<div class="page-hero">
  <div class="wrap">
    <span class="eyebrow">About Us</span>
    <h1 class="section-title">The <em>New Way</em> Forward</h1>
    <div class="section-rule"></div>
  </div>
</div>
<?php
ComponentLoader::render('about');
ComponentLoader::render('process');
ComponentLoader::render('why');
ComponentLoader::render('cta-band');
