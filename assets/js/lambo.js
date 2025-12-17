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
  { kicker: 'NEW SEASON', title: 'STEP INTO\nSTYLE' },
  { kicker: 'URBAN WEAR', title: 'MADE FOR\nEVERYDAY' },
  { kicker: 'LIMITED DROP', title: 'MOVE\nWITH CONFIDENCE' },
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