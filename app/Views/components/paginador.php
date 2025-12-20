<?php if (($paginador['totalRegistros'] ?? 0) >= 1): ?>
  <nav aria-label="Paginación">
    <ul class="pagination justify-content-center">

      <?php $page = (int)($paginador['paginador'] ?? 1); ?>
      <?php $totalPages = (int)($paginador['numeroDePaginas'] ?? 1); ?>

      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $page <= 1 ? '#' : '?controlador=socio&accion=socio&pagina=' . ($page - 1) ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $page === $i ? 'active' : '' ?>">
          <a class="page-link" href="?controlador=socio&accion=socio&pagina=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $page >= $totalPages ? '#' : '?controlador=socio&accion=socio&pagina=' . ($page + 1) ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>

    </ul>
  </nav>
<?php endif; ?>
