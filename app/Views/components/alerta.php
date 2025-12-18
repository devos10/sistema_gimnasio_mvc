<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($alertasFlash)): ?>
<script>
  (function () {
    const alerts = <?= json_encode($alertasFlash, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    alerts.forEach(a => {
      const base = {
        icon: a.icon,
        title: a.title,
        text: a.text
      };

      // opciones extra (timer, toast, position, etc.)
      const opts = (a.opts && typeof a.opts === 'object') ? a.opts : {};

      Swal.fire(Object.assign(base, opts));
    });
  })();
</script>
<?php endif; ?>
