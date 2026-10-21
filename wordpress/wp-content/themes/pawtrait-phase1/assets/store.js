(() => {
  const button = document.querySelector('.menu');
  const nav = document.querySelector('#navigation');
  if (!button || !nav) return;
  const groups = [...nav.querySelectorAll('.nav-group')];
  const closeGroups = () => groups.forEach(group => { group.open = false; });
  const closeMenu = () => { button.setAttribute('aria-expanded', 'false'); nav.classList.remove('open'); closeGroups(); };
  button.addEventListener('click', () => {
    const open = button.getAttribute('aria-expanded') !== 'true';
    button.setAttribute('aria-expanded', String(open)); nav.classList.toggle('open', open);
    if (!open) closeGroups();
  });
  groups.forEach(group => group.querySelector('summary').addEventListener('click', () => {
    if (!group.open) groups.forEach(other => { if (other !== group) other.open = false; });
  }));
  document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;
    const activeGroup = groups.find(group => group.open);
    if (activeGroup) { closeGroups(); activeGroup.querySelector('summary').focus(); }
    else if (button.getAttribute('aria-expanded') === 'true') { closeMenu(); button.focus(); }
  });
  document.addEventListener('click', event => { if (!nav.contains(event.target) && !button.contains(event.target)) closeMenu(); });
  document.addEventListener('focusin', event => { if (!nav.contains(event.target) && !button.contains(event.target)) closeGroups(); });
  nav.addEventListener('click', event => { if (event.target.closest('a')) closeMenu(); });
  window.matchMedia('(min-width: 1150px)').addEventListener('change', closeMenu);
})();
