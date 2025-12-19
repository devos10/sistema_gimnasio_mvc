<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (!empty($alertasFlash)): ?>
<script>
  (function () {
    const alerts = <?= json_encode($alertasFlash, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    alerts.forEach(a => {
      const opts = (a.opts && typeof a.opts === 'object') ? a.opts : {};

      // icon final
      const icon = a.icon || opts.icon || 'info';

      // ¿toast o modal?
      const isToast = opts.toast === true;

      const base = {
        icon,
        title: a.title,
        text: a.text,
      };

      //mezclamos customClass sin romper lo que venga en opts
      const existingCC = (opts.customClass && typeof opts.customClass === 'object') ? opts.customClass : {};
      const modeClass = isToast ? `toast-${icon}` : `modal-${icon}`;

      const mergedCustomClass = Object.assign({}, existingCC, {
        popup: [existingCC.popup, modeClass].filter(Boolean).join(' ')
      });

      Swal.fire(Object.assign({}, base, opts, { customClass: mergedCustomClass }));
    });
  })();
</script>
<?php endif; ?>
