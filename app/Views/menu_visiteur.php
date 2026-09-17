
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= base_url('/') ?>">Accueil</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Liens alignés à gauche -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
        <a class="nav-link" href="<?= base_url('index.php/message/gestion') ?>">Contact</a>
        </li>
      </ul>

      <!-- Lien aligné à droite -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light px-3" href="<?= base_url('index.php/compte/connecter') ?>">Connexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
