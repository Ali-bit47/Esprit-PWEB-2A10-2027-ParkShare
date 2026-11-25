























(function (global) {
  'use strict';

  var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;

  function normalizePhone(v) {
    return v.replace(/[\s.\-]/g, '').replace(/^(\+216|00216)/, '');
  }

  function parseDate(v) {
    var m = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(v.trim());
    if (!m) { return null; }
    var d = new Date(+m[3], +m[2] - 1, +m[1]);
    
    if (d.getFullYear() !== +m[3] || d.getMonth() !== +m[2] - 1 || d.getDate() !== +m[1]) { return null; }
    return d;
  }

  var RULES = {
    required: function (v) { return v.trim() !== ''; },
    minLen: function (v, n) { return v.trim().length >= n; },
    maxLen: function (v, n) { return v.trim().length <= n; },
    pattern: function (v, re) { return re.test(v.trim()); },
    email: function (v) { return EMAIL_RE.test(v.trim()) && v.trim().length <= 150; },
    phoneTN: function (v) { return /^[234579]\d{7}$/.test(normalizePhone(v.trim())); },
    strongPassword: function (v) {
      return v.length >= 8 && v.length <= 72 && /[A-Z]/.test(v) && /[a-z]/.test(v) && /\d/.test(v);
    },
    match: function (v, other, form) { return v === valueOf(form, other); },
    different: function (v, other, form) { return v === '' || v !== valueOf(form, other); },
    oneOf: function (v, list) { return list.indexOf(v) !== -1; },
    futureDate: function (v) {
      var d = parseDate(v);
      if (!d) { return false; }
      var today = new Date(); today.setHours(0, 0, 0, 0);
      return d >= today;
    },
    custom: function (v, fn, form) { return fn(v, form); }
  };

  
  function fieldOf(form, name) { return form.elements[name]; }

  function inputsOf(form, name) {
    var el = fieldOf(form, name);
    if (!el) { return []; }
    return el.length !== undefined && !el.tagName ? Array.prototype.slice.call(el) : [el];
  }

  function valueOf(form, name) {
    var inputs = inputsOf(form, name);
    if (!inputs.length) { return ''; }
    var first = inputs[0];
    if (first.type === 'radio') {
      var checked = inputs.filter(function (i) { return i.checked; })[0];
      return checked ? checked.value : '';
    }
    if (first.type === 'checkbox') { return first.checked ? first.value : ''; }
    return first.value;
  }

  
  function errorBox(form, name) {
    var box = form.querySelector('.field-error[data-for="' + name + '"]');
    if (box) { return box; }
    var inputs = inputsOf(form, name);
    if (!inputs.length) { return null; }
    box = document.createElement('small');
    box.className = 'field-error';
    box.setAttribute('data-for', name);
    var anchor = inputs[0].closest('.choice-group, .pw-wrap, .check') || inputs[0];
    anchor.insertAdjacentElement('afterend', box);
    return box;
  }

  function setState(form, name, message) {
    var box = errorBox(form, name);
    inputsOf(form, name).forEach(function (input) {
      input.classList.toggle('is-invalid', !!message);
      input.classList.toggle('is-valid', !message && input.type !== 'radio' && input.type !== 'checkbox' && input.value !== '');
      input.setAttribute('aria-invalid', message ? 'true' : 'false');
    });
    if (box) {
      box.textContent = message || '';
      box.classList.toggle('show', !!message);
    }
  }

  
  function check(form, name, rules) {
    var value = valueOf(form, name);
    for (var i = 0; i < rules.length; i++) {
      var r = rules[i];
      var type = r[0];
      if (type === 'optional') {
        if (value.trim() === '') { return null; }
        continue;
      }
      var hasArg = !(type === 'required' || type === 'email' || type === 'phoneTN' || type === 'strongPassword' || type === 'futureDate');
      var arg = hasArg ? r[1] : undefined;
      var message = hasArg ? r[2] : r[1];
      if (!RULES[type](value, arg, form)) { return message; }
    }
    return null;
  }

  function attach(formId, schema, options) {
    var form = document.getElementById(formId);
    if (!form) { return null; }
    options = options || {};
    var touched = {};

    function validateOne(name) {
      var message = check(form, name, schema[name]);
      setState(form, name, message);
      return message;
    }

    
    var dependents = {};
    Object.keys(schema).forEach(function (name) {
      schema[name].forEach(function (r) {
        if (r[0] === 'match' || r[0] === 'different') {
          (dependents[r[1]] = dependents[r[1]] || []).push(name);
        }
      });
    });

    Object.keys(schema).forEach(function (name) {
      inputsOf(form, name).forEach(function (input) {
        var live = input.type === 'radio' || input.type === 'checkbox' || input.tagName === 'SELECT' ? 'change' : 'input';
        input.addEventListener('blur', function () { touched[name] = true; validateOne(name); });
        input.addEventListener(live, function () {
          if (live === 'change') { touched[name] = true; }
          if (touched[name]) { validateOne(name); }
          (dependents[name] || []).forEach(function (dep) { if (touched[dep]) { validateOne(dep); } });
        });
      });
    });

    form.addEventListener('submit', function (event) {
      var errors = [];
      Object.keys(schema).forEach(function (name) {
        touched[name] = true;
        var message = validateOne(name);
        if (message) { errors.push(name); }
      });

      var summary = form.querySelector('.js-summary');
      if (errors.length) {
        event.preventDefault();
        if (summary) {
          summary.textContent = errors.length === 1
            ? 'Un champ est à corriger avant l’envoi.'
            : errors.length + ' champs sont à corriger avant l’envoi.';
          summary.hidden = false;
        }
        var first = inputsOf(form, errors[0])[0];
        if (first) { first.focus(); }
      } else if (summary) {
        summary.hidden = true;
      }
      if (!errors.length && options.onValid) { options.onValid(form, event); }
    });

    return { validate: validateOne };
  }

  global.PSValidator = { attach: attach, normalizePhone: normalizePhone };
})(window);
