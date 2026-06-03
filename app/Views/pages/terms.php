<?php

declare(strict_types=1);
?>
<div class="page-hero">
  <div class="wrap">
    <span class="eyebrow">Legal</span>
    <h1 class="section-title">Terms of <em>Service</em></h1>
    <div class="section-rule"></div>
  </div>
</div>
<section class="legal-content">
  <div class="wrap">
    <p class="legal-updated">Last updated: <?= e(date('F j, Y')) ?></p>
    <div class="legal-body">
      <p>By using the <?= e(config('site.name')) ?> website, you agree to these terms. If you do not agree, please do not use this site.</p>
      <h2>Services</h2>
      <p>We provide career consultancy, job placement assistance, and related services. Outcomes depend on individual qualifications, market conditions, and employer requirements. We do not guarantee placement.</p>
      <h2>Website Use</h2>
      <p>You agree not to misuse the site, attempt unauthorized access, or submit false or harmful information through our forms.</p>
      <h2>Limitation of Liability</h2>
      <p>Information on this website is provided in good faith. We are not liable for indirect damages arising from use of the site or reliance on general information published here.</p>
      <h2>Governing Law</h2>
      <p>These terms are governed by the laws of India. Disputes shall be subject to courts in Kerala, India.</p>
      <h2>Contact</h2>
      <p><?= e(config('site.address.line1')) ?>, <?= e(config('site.address.line2')) ?> — <a href="mailto:<?= e(config('site.email')) ?>"><?= e(config('site.email')) ?></a></p>
    </div>
  </div>
</section>
