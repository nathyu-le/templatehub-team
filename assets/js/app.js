/* assets/js/app.js
 * SimpleShop UI JS (modern, clean)
 * - Add to cart (AJAX)
 * - Cart update/remove (AJAX)
 * - Qty +/- controls
 * - Toast notifications
 */

(() => {
  // ---------- helpers ----------
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  const postForm = async (url, dataObj) => {
    const body = new URLSearchParams();
    Object.entries(dataObj).forEach(([k, v]) => body.append(k, v));

    const res = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
      body: body.toString(),
      credentials: "same-origin",
    });

    const text = await res.text();
    // Expect JSON; if server returns HTML, show debug
    try {
      return JSON.parse(text);
    } catch {
      return { ok: false, message: "Server did not return JSON.", raw: text };
    }
  };

  const setCartCount = (count) => {
    const badge = $('[data-cart-count]');
    if (badge) badge.textContent = String(count ?? 0);
  };

  // ---------- toast ----------
  const ensureToastRoot = () => {
    let root = $("#toastRoot");
    if (!root) {
      root = document.createElement("div");
      root.id = "toastRoot";
      root.style.position = "fixed";
      root.style.right = "16px";
      root.style.bottom = "16px";
      root.style.zIndex = "9999";
      root.style.display = "grid";
      root.style.gap = "10px";
      document.body.appendChild(root);
    }
    return root;
  };

  const toast = (msg, type = "info") => {
    const root = ensureToastRoot();
    const el = document.createElement("div");
    el.style.background = "#fff";
    el.style.border = "1px solid rgba(0,0,0,.12)";
    el.style.borderLeft = type === "ok" ? "4px solid #16a34a" : type === "err" ? "4px solid #dc2626" : "4px solid #2563eb";
    el.style.boxShadow = "0 12px 30px rgba(0,0,0,.12)";
    el.style.borderRadius = "14px";
    el.style.padding = "10px 12px";
    el.style.maxWidth = "340px";
    el.style.fontSize = "13px";
    el.style.color = "#0f172a";
    el.innerHTML = `<div style="display:flex;gap:10px;align-items:flex-start;">
        <div style="font-weight:800;line-height:1;">${type === "ok" ? "✓" : type === "err" ? "!" : "i"}</div>
        <div style="line-height:1.35;">${msg}</div>
      </div>`;
    root.appendChild(el);

    setTimeout(() => {
      el.style.opacity = "0";
      el.style.transform = "translateY(6px)";
      el.style.transition = "all .25s ease";
      setTimeout(() => el.remove(), 260);
    }, 2200);
  };

  // ---------- qty +/- controls ----------
  // HTML expected:
  // <div class="qty" data-qty>
  //   <button type="button" data-qty-minus>-</button>
  //   <input type="number" name="qty" value="1" min="1">
  //   <button type="button" data-qty-plus>+</button>
  // </div>
  document.addEventListener("click", (e) => {
    const minus = e.target.closest("[data-qty-minus]");
    const plus = e.target.closest("[data-qty-plus]");
    if (!minus && !plus) return;

    const wrap = e.target.closest("[data-qty]");
    if (!wrap) return;

    const input = $("input", wrap);
    if (!input) return;

    const cur = parseInt(input.value || "1", 10);
    const next = plus ? cur + 1 : Math.max(1, cur - 1);
    input.value = String(next);

    // trigger change event if someone listens
    input.dispatchEvent(new Event("change", { bubbles: true }));
  });

  // ---------- ADD TO CART (AJAX) ----------
  // Button expected:
  // <button type="button" data-add-cart="PRODUCT_ID" data-qty-input="#qtyInput">Add</button>
  // Or:
  // <form data-add-cart-form action="/cart_add_ajax.php"> ... </form>
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest("[data-add-cart]");
    if (!btn) return;

    e.preventDefault();

    const productId = btn.getAttribute("data-add-cart");
    if (!productId) return;

    let qty = 1;
    const qtySel = btn.getAttribute("data-qty-input");
    if (qtySel) {
      const qtyEl = $(qtySel);
      if (qtyEl) qty = Math.max(1, parseInt(qtyEl.value || "1", 10));
    }

    btn.disabled = true;
    const oldText = btn.textContent;
    btn.textContent = "Adding...";

    const data = await postForm("/cart_add_ajax.php", { product_id: productId, qty });

    btn.disabled = false;
    btn.textContent = oldText;

    if (data.ok) {
      setCartCount(data.count);
      toast(data.message || "Added to cart.", "ok");
    } else {
      toast(data.message || "Add to cart failed.", "err");
      // optional debug
      // console.log(data.raw);
      if (data.redirect) window.location.href = data.redirect;
    }
  });

  // ---------- CART UPDATE/REMOVE (AJAX) ----------
  // Expected in cart rows:
  // <button type="button" data-cart-update="CART_ITEM_ID">Update</button>
  // <input data-cart-qty="CART_ITEM_ID" type="number" value="1">
  // <button type="button" data-cart-remove="CART_ITEM_ID">Remove</button>
  document.addEventListener("click", async (e) => {
    const up = e.target.closest("[data-cart-update]");
    const rm = e.target.closest("[data-cart-remove]");
    if (!up && !rm) return;

    e.preventDefault();

    const cartItemId = (up || rm).getAttribute(up ? "data-cart-update" : "data-cart-remove");
    if (!cartItemId) return;

    if (rm) {
      if (!confirm("Remove this item?")) return;
      const data = await postForm("/cart_api.php", { action: "remove", cart_item_id: cartItemId });
      if (data.ok) {
        setCartCount(data.count);
        toast(data.message || "Removed.", "ok");
        // remove row
        const row = rm.closest("[data-cart-row]");
        if (row) row.remove();
        // update totals
        if (typeof data.subtotal !== "undefined") {
          const el = $("[data-cart-subtotal]");
          if (el) el.textContent = data.subtotal_text || el.textContent;
        }
      } else {
        toast(data.message || "Remove failed.", "err");
      }
      return;
    }

    // update
    const qtyInput = $(`[data-cart-qty="${cartItemId}"]`);
    const qty = qtyInput ? Math.max(1, parseInt(qtyInput.value || "1", 10)) : 1;

    const data = await postForm("/cart_api.php", { action: "update", cart_item_id: cartItemId, quantity: qty });

    if (data.ok) {
      setCartCount(data.count);
      toast(data.message || "Updated.", "ok");

      // update line total
      const line = $(`[data-line-total="${cartItemId}"]`);
      if (line && data.line_total_text) line.textContent = data.line_total_text;

      // update subtotal
      const el = $("[data-cart-subtotal]");
      if (el && data.subtotal_text) el.textContent = data.subtotal_text;
    } else {
      toast(data.message || "Update failed.", "err");
    }
  });

})();

// lambo 
// ===== HERO LAMBO controls =====
(() => {
  const hero = document.querySelector('#hero');
  if (!hero) return;

  const video = hero.querySelector('.hero-video');
  const dotsWrap = hero.querySelector('[data-hero-dots]');
  const pauseBtn = hero.querySelector('[data-hero-toggle]');
  const title = hero.querySelector('.hero-title');
  const kicker = hero.querySelector('.hero-kicker');

  const slides = [
    { kicker: 'TEMERARIO', title: 'FROM THE ALPS\nTO THE SEA' },
    { kicker: 'PERFORMANCE', title: 'BUILT FOR\nTHE ROAD' },
    { kicker: 'DESIGN', title: 'PURE\nAERODYNAMICS' },
  ];

  const setActive = (idx) => {
    const s = slides[idx] || slides[0];
    kicker.textContent = s.kicker;
    title.innerHTML = s.title.replace('\n', '<br>');
    if (dotsWrap) {
      dotsWrap.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('is-active', i === idx));
    }
  };

  if (dotsWrap) {
    dotsWrap.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-hero-go]');
      if (!btn) return;
      setActive(parseInt(btn.dataset.heroGo, 10) || 0);
    });
  }

  if (pauseBtn && video) {
    pauseBtn.addEventListener('click', () => {
      if (video.paused) {
        video.play();
        pauseBtn.querySelector('.icon').textContent = 'Ⅱ';
      } else {
        video.pause();
        pauseBtn.querySelector('.icon').textContent = '▶';
      }
    });
  }

  setActive(0);
})();
//end lambo