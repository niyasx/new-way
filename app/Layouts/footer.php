<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="fb-logo">
        <?php $logoSize = 34;
        require dirname(__DIR__) . '/Components/logo-icon.php'; ?>
        <span class="fb-name">New Way Consultancy</span>
      </div>
      <span class="fb-tag">Your Trusted Career Partner</span>
      <p>Perinthalmanna's leading career and recruitment consultancy, connecting talent with opportunity across India and the world since day one.</p>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="#services">Career Counseling</a></li>
        <li><a href="#services">Overseas Placement</a></li>
        <li><a href="#services">Visa Guidance</a></li>
        <li><a href="#services">Resume Building</a></li>
        <li><a href="#services">Document Attestation</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="#about">About Us</a></li>
        <li><a href="#industries">Industries</a></li>
        <li><a href="#process">Our Process</a></li>
        <li><a href="#testimonials">Reviews</a></li>
        <li><a href="#faq">FAQ</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <p>KIMS Avenue Building<br>Shanti Nagar, Perinthalmanna<br>Kerala 679322, India</p>
      <p><a href="tel:<?= e(config('site.phone_primary')) ?>"><?= e(config('site.phone_primary_display')) ?></a><br><a href="tel:<?= e(config('site.phone_secondary')) ?>"><?= e(config('site.phone_secondary_display')) ?></a></p>
      <p><a href="mailto:newwaypmna@gmail.com">newwaypmna@gmail.com</a></p>
      <p>Mon–Sat · 9:30 AM – 6:00 PM</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 New Way Consultancy, Perinthalmanna. All rights reserved.</p>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="https://new-way.in" target="_blank">new-way.in</a>
    </div>
  </div>
</footer>
