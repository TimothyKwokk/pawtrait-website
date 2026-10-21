(() => {
  const button = document.querySelector('.menu');
  const nav = document.querySelector('#navigation');
  if (!button || !nav) return;
  const close = () => { button.setAttribute('aria-expanded','false'); nav.classList.remove('open'); };
  button.addEventListener('click', () => {
    const open = button.getAttribute('aria-expanded') !== 'true';
    button.setAttribute('aria-expanded',String(open)); nav.classList.toggle('open',open);
  });
  document.addEventListener('keydown', e => { if(e.key === 'Escape' && button.getAttribute('aria-expanded')==='true') { close(); button.focus(); } });
  document.addEventListener('click', e => { if(!nav.contains(e.target) && !button.contains(e.target)) close(); });
  nav.addEventListener('click', e => { if(e.target.closest('a')) close(); });
})();
