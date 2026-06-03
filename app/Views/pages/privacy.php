<?php

declare(strict_types=1);
?>
<div class="page-hero">
  <div class="wrap">
    <span class="eyebrow">Legal</span>
    <h1 class="section-title">Privacy <em>Policy</em></h1>
    <div class="section-rule"></div>
  </div>
</div>
<section class="legal-content">
  <div class="wrap">
    <p class="legal-updated">Last updated: <?= e(date('F j, Y')) ?></p>
    <div class="legal-body">
      <p><?= e(config('site.name')) ?> ("we", "our", or "us") respects your privacy. This policy explains how we collect, use, and protect information when you visit our website or submit a contact form.</p>
      <h2>Information We Collect</h2>
      <p>When you contact us, we may collect your name, email address, phone number, service interest, and message content. We do not sell your personal information to third parties.</p>
      <h2>How We Use Your Information</h2>
      <p>We use submitted information solely to respond to enquiries, provide career consultancy services, and improve our communication with you.</p>
      <h2>Data Security</h2>
      <p>We apply reasonable technical and organizational measures including CSRF protection, input validation, and secure transmission where available.</p>
      <h2>Contact</h2>
      <p>Questions about this policy? Email <a href="mailto:<?= e(config('site.email')) ?>"><?= e(config('site.email')) ?></a> or call <?= e(config('site.phone_primary_display')) ?>.</p>
    </div>
  </div>
</section>
