




(function () {
  'use strict';
  if (!window.PSValidator) { return; }

  var NAME_RE = /^[\p{L}][\p{L} '\-]{1,49}$/u;
  var USERNAME_RE = /^[a-zA-Z0-9._\-]{3,50}$/;

  var nom = [
    ['required', 'Le nom est obligatoire.'],
    ['pattern', NAME_RE, 'Le nom doit contenir de 2 à 50 lettres (espaces, tirets et apostrophes acceptés).']
  ];
  var prenom = [
    ['required', 'Le prénom est obligatoire.'],
    ['pattern', NAME_RE, 'Le prénom doit contenir de 2 à 50 lettres (espaces, tirets et apostrophes acceptés).']
  ];
  var username = [
    ['required', 'Le nom d’utilisateur est obligatoire.'],
    ['pattern', USERNAME_RE, 'De 3 à 50 caractères : lettres, chiffres, point, _ ou - uniquement.']
  ];
  var email = [
    ['required', 'L’adresse email est obligatoire.'],
    ['email', 'Adresse email invalide (exemple : nom@domaine.tn).']
  ];
  var telephone = [
    ['required', 'Le numéro de téléphone est obligatoire.'],
    ['phoneTN', 'Numéro tunisien invalide : 8 chiffres (exemple : 22 123 456).']
  ];
  var passwordRequired = [
    ['required', 'Le mot de passe est obligatoire.'],
    ['strongPassword', 'Entre 8 et 72 caractères, avec au moins une majuscule, une minuscule et un chiffre.']
  ];
  var passwordOptional = [
    ['optional'],
    ['strongPassword', 'Entre 8 et 72 caractères, avec au moins une majuscule, une minuscule et un chiffre.']
  ];
  var confirmation = [
    ['custom', function (v, form) { return form.elements.password.value === '' || v !== ''; }, 'Confirmez le mot de passe.'],
    ['match', 'password', 'Les deux mots de passe ne correspondent pas.']
  ];

  PSValidator.attach('form-register', {
    nom: nom, prenom: prenom, username: username, email: email, telephone: telephone,
    role: [['required', 'Choisissez votre profil.'], ['oneOf', ['client', 'proprietaire'], 'Profil invalide.']],
    password: passwordRequired,
    password_confirm: confirmation,
    terms: [['required', 'Vous devez accepter les conditions d’utilisation.']]
  });

  PSValidator.attach('form-login', {
    email: [['required', 'Veuillez saisir votre adresse email.'], ['email', 'Adresse email invalide.']],
    password: [['required', 'Veuillez saisir votre mot de passe.']]
  });

  var userForm = document.getElementById('form-user');
  if (userForm) {
    var editMode = userForm.getAttribute('data-mode') === 'edit';
    PSValidator.attach('form-user', {
      nom: nom, prenom: prenom, username: username, email: email, telephone: telephone,
      role: [['required', 'Choisissez un rôle.'], ['oneOf', ['client', 'proprietaire', 'technicien', 'admin'], 'Rôle invalide.']],
      statut: [['required', 'Choisissez un statut.'], ['oneOf', ['actif', 'bloque'], 'Statut invalide.']],
      password: editMode ? passwordOptional : passwordRequired,
      password_confirm: confirmation
    });
  }

  
  PSValidator.attach('form-profile', {
    nom: nom, prenom: prenom, username: username, email: email, telephone: telephone
  });

  
  PSValidator.attach('form-password', {
    current_password: [['required', 'Saisissez votre mot de passe actuel.']],
    password: passwordRequired.concat([['different', 'current_password', 'Le nouveau mot de passe doit être différent de l’actuel.']]),
    password_confirm: confirmation
  });

  
  PSValidator.attach('form-delete-account', {
    confirm_password: [['required', 'Saisissez votre mot de passe pour confirmer.']]
  });

  
  PSValidator.attach('form-search', {
    lieu: [
      ['required', 'Indiquez un quartier ou une adresse.'],
      ['minLen', 2, 'Au moins 2 caractères.'],
      ['maxLen', 100, '100 caractères maximum.'],
      ['pattern', /^[\p{L}0-9 '\-,.]+$/u, 'Caractères non autorisés.']
    ],
    date: [
      ['required', 'Choisissez une date.'],
      ['futureDate', 'Date invalide : format JJ/MM/AAAA, aujourd’hui ou plus tard.']
    ],
    duree: [['required', 'Choisissez une durée.'], ['oneOf', ['1', '2', '3', '4', '6', '8', '12', '24'], 'Durée invalide.']]
  });

  PSValidator.attach('form-filters', {
    q: [['optional'], ['maxLen', 100, '100 caractères maximum.'], ['pattern', /^[^<>]*$/, 'Les caractères < et > ne sont pas autorisés.']]
  });
})();

if (window.PSValidator) {
  PSValidator.attach('form-header-search', {
    q: [['optional'], ['maxLen', 100, '100 caractères maximum.'], ['pattern', /^[^<>]*$/, 'Caractères < et > interdits.']]
  });
}
