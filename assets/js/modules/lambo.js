
(() => {
  const hero = document.querySelector('#hero');
  if (!hero) return;

  const slides = [
    { kicker: 'NEW SEASON',   title: 'STEP INTO\nSTYLE' },
    { kicker: 'URBAN WEAR',   title: 'MADE FOR\nEVERYDAY' },
    { kicker: 'LIMITED DROP', title: 'MOVE\nWITH CONFIDENCE' },
  ];

  const title = hero.querySelector('.hero-title');
  const kicker = hero.querySelector('.hero-kicker');
  const dotsWrap = hero.querySelector('[data-hero-dots]');

  const setActive = (idx) => {
    const s = slides[idx] || slides[0];
    if (kicker) kicker.textContent = s.kicker;
    if (title)  title.innerHTML = s.title.replace('\n', '<br>');

    if (dotsWrap) {
      dotsWrap.querySelectorAll('.dot')
        .forEach((d, i) => d.classList.toggle('is-active', i === idx));
    }
  };

  // dots click
  if (dotsWrap) {
    dotsWrap.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-hero-go]');
      if (!btn) return;
      e.preventDefault();
      const idx = parseInt(btn.dataset.heroGo, 10);
      setActive(Number.isFinite(idx) ? idx : 0);
    });
  }

  // ✅ PAUSE/PLAY bắt click kiểu delegation (ăn chắc)
  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-hero-toggle]');
    if (!btn) return;

    // chỉ xử lý nếu nút nằm trong hero này
    if (!hero.contains(btn)) return;

    e.preventDefault();
    e.stopPropagation();

    const video = hero.querySelector('.hero-video');
    if (!video) return;

    const icon = btn.querySelector('.icon');

    try {
      if (video.paused) {
        await video.play();
        if (icon) icon.textContent = 'Ⅱ';
      } else {
        video.pause();
        if (icon) icon.textContent = '▶';
      }
    } catch (err) {
      console.warn('play() blocked:', err);
    }
  }, true);

  setActive(0);
})();
