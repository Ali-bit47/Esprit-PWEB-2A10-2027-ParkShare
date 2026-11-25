



(function () {
  'use strict';

  
  document.querySelectorAll('.pw-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = document.getElementById(btn.getAttribute('data-target'));
      if (!input) { return; }
      var show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.textContent = show ? 'Masquer' : 'Afficher';
    });
  });

  
  document.querySelectorAll('[data-strength]').forEach(function (meter) {
    var input = document.getElementById(meter.getAttribute('data-strength'));
    var label = document.getElementById(meter.getAttribute('data-strength') + '-strength-label');
    if (!input) { return; }
    input.addEventListener('input', function () {
      var v = input.value, score = 0;
      if (v.length >= 8) { score++; }
      if (/[A-Z]/.test(v) && /[a-z]/.test(v)) { score++; }
      if (/\d/.test(v)) { score++; }
      if (/[^A-Za-z0-9]/.test(v) || v.length >= 12) { score++; }
      if (!v) { score = 0; }
      meter.setAttribute('data-level', String(score));
      if (label) { label.textContent = ['', 'Faible', 'Moyen', 'Bon', 'Excellent'][score]; }
    });
  });

  
  document.querySelectorAll('form.js-confirm').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (event.defaultPrevented) { return; } 
      if (!window.confirm(form.getAttribute('data-confirm') || 'Confirmer cette action ?')) {
        event.preventDefault();
        event.stopImmediatePropagation();
      }
    });
  });

  
  document.querySelectorAll('.js-autosubmit').forEach(function (select) {
    select.addEventListener('change', function () { select.form.requestSubmit(); });
  });

  
  var top = document.querySelector('.back-to-top');
  if (top) {
    window.addEventListener('scroll', function () { top.classList.toggle('show', window.scrollY > 300); });
  }
})();
