<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand">Factum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="?page=clients"><i class="bi bi-people"></i>Clientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=bills"><i class="bi bi-receipt"></i>Facturas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=budgets"><i class="bi bi-easel2"></i>Presupuestos</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-three-dots"></i>Más opciones
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="?page=bill-options"><i class="bi bi-cloud-arrow-down"></i>Descargar y archivar</a></li>
            <li><a class="dropdown-item" href="?page=archive"><i class="bi bi-box-seam"></i>Archivo</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/scripts/php/logout.php"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>