document.addEventListener('DOMContentLoaded', () => {

  /* ===============================
     Tabs smooth scroll
  =============================== */
  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', () => {
      window.scrollBy({ top: 0, behavior: 'smooth' });
    });
  });

  /* ===============================
     Quantity input effect
  =============================== */
  const qtyInput = document.querySelector('input[name="qty"]');
  if (qtyInput) {
    qtyInput.addEventListener('change', () => {
      qtyInput.classList.add('border-primary');
      setTimeout(() => qtyInput.classList.remove('border-primary'), 300);
    });
  }

  /* ===============================
     Size selector
  =============================== */
  const sizeButtons = document.querySelectorAll('.size-btn');
  const sizeInput   = document.getElementById('selectedSize');

  if (sizeButtons.length && sizeInput) {
    sizeButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        sizeButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        sizeInput.value = btn.dataset.size;
      });
    });
  }

  /* ===============================
     Validate size before add to cart
  =============================== */
  const cartForm = document.querySelector('form[action="/cart_add.php"]');
  if (cartForm && sizeInput) {
    cartForm.addEventListener('submit', e => {
      if (!sizeInput.value) {
        e.preventDefault();
        alert('Vui lòng chọn size trước khi thêm vào giỏ hàng.');
      }
    });
  }

});
