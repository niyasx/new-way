/* ── Navbar scroll shadow ── */
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 50));

/* ── Mobile nav toggle ── */
function toggleNav() {
  const menu = document.getElementById('nav-menu');
  const toggle = document.getElementById('nav-toggle');
  menu.classList.toggle('open');
  toggle.classList.toggle('open');
}
// close on link click
document.querySelectorAll('#nav-menu a').forEach(a => {
  a.addEventListener('click', () => {
    document.getElementById('nav-menu').classList.remove('open');
    document.getElementById('nav-toggle').classList.remove('open');
  });
});

/* ── Scroll reveal ── */
const revealEls = document.querySelectorAll('.reveal');
const revealIO = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('in'), i * 70);
      revealIO.unobserve(e.target);
    }
  });
}, { threshold: 0.08 });
revealEls.forEach(el => revealIO.observe(el));

/* ── FAQ accordion ── */
function toggleFaq(btn) {
  const item = btn.closest('.faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}

/* ── Contact Form — uses FormSubmit.co ── */
const form = document.getElementById('contact-form');
const submitBtn = document.getElementById('submit-btn');
const formWrap = document.getElementById('contact-form-wrap');
const formSuccess = document.getElementById('form-success');

if (form && submitBtn && formWrap && formSuccess) form.addEventListener('submit', async (e) => {
  e.preventDefault();

  // Basic validation
  const name = form.querySelector('[name="name"]').value.trim();
  const email = form.querySelector('[name="email"]').value.trim();
  const message = form.querySelector('[name="message"]').value.trim();
  if (!name || !email || !message) {
    alert('Please fill in all required fields (Name, Email, Message).');
    return;
  }
  const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRx.test(email)) {
    alert('Please enter a valid email address.');
    return;
  }

  // Show loading
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin .7s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Sending…';

  // Build FormData
  const formData = new FormData(form);

  try {
    const res = await fetch('https://formsubmit.co/ajax/newwaypmna@gmail.com', {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      body: formData
    });
    if (res.ok) {
      formWrap.style.display = 'none';
      formSuccess.style.display = 'block';
    } else {
      throw new Error('Server error');
    }
  } catch (err) {
    // Fallback: open mail client
    const sub = encodeURIComponent('Enquiry from New Way Consultancy Website');
    const body = encodeURIComponent(
      `Name: ${name}\nEmail: ${email}\nPhone: ${form.querySelector('[name="phone"]').value}\nService: ${form.querySelector('[name="service"]').value}\n\nMessage:\n${message}`
    );
    window.location.href = `mailto:newwaypmna@gmail.com?subject=${sub}&body=${body}`;
    submitBtn.disabled = false;
    submitBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 20-7z"/></svg> Send Message';
  }
});

/* spinner keyframe */
const styleTag = document.createElement('style');
styleTag.textContent = '@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}';
document.head.appendChild(styleTag);
