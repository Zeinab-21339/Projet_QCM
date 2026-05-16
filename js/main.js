// Simple frontend-only helpers for the QCM UI
const fullscreenBtn = document.getElementById('fullscreenBtn');
if (fullscreenBtn) {
  fullscreenBtn.addEventListener('click', () => {
    if (!document.fullscreenElement) document.documentElement.requestFullscreen?.();
  });
}

let remaining = 10 * 60;
const timer = document.getElementById('timer');
if (timer) {
  setInterval(() => {
    remaining = Math.max(0, remaining - 1);
    const m = String(Math.floor(remaining / 60)).padStart(2, '0');
    const s = String(remaining % 60).padStart(2, '0');
    timer.textContent = `${m}:${s}`;
  }, 1000);
}

document.addEventListener('visibilitychange', () => {
  if (document.hidden) alert('Warning: changing tab can cancel the attempt.');
});
