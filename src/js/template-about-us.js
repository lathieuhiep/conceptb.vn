(function () {
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('about-publication-modal');

    if (!modal) {
      return;
    }

    var modalBody = modal.querySelector('[data-publication-modal-body]');

    modal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      var templateId = trigger ? trigger.getAttribute('data-publication-template') : '';
      var template = templateId ? document.getElementById(templateId) : null;

      if (!modalBody || !template) {
        return;
      }

      modalBody.innerHTML = '';
      modalBody.appendChild(template.content.cloneNode(true));

      modalBody.querySelectorAll('script').forEach(function (script) {
        var freshScript = document.createElement('script');

        Array.prototype.slice.call(script.attributes).forEach(function (attr) {
          freshScript.setAttribute(attr.name, attr.value);
        });

        freshScript.text = script.text;
        script.parentNode.replaceChild(freshScript, script);
      });
    });

    modal.addEventListener('shown.bs.modal', function () {
      if (window.DEARFLIP && typeof window.DEARFLIP.parseBooks === 'function') {
        window.DEARFLIP.parseBooks();
      }
    });

    modal.addEventListener('hidden.bs.modal', function () {
      if (modalBody) {
        modalBody.innerHTML = '';
      }
    });
  });
})();
