(function () {
  document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('about-publication-modal');

    if (modal) {
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
    }

    if (window.jQuery && typeof window.jQuery.fn.magnificPopup === 'function') {
      window.jQuery('.about-certification__gallery').magnificPopup({
        delegate: 'a.about-certification__link',
        type: 'image',
        gallery: {
          enabled: true,
        },
      });
    }

    var slider = document.querySelector('[data-about-technology-slider]');

    if (!slider || typeof window.Swiper !== 'function') {
      return;
    }

    var section = slider.closest('.about-technology');
    var title = section ? section.querySelector('[data-about-technology-title]') : null;
    var description = section ? section.querySelector('[data-about-technology-description]') : null;
    var progress = section ? section.querySelector('[data-about-technology-progress]') : null;
    var slideCount = slider.querySelectorAll('[data-about-technology-slide]').length;

    var updateActiveContent = function (swiper) {
      var activeSlide = swiper.slides[swiper.activeIndex];
      var activeTitle = activeSlide ? activeSlide.getAttribute('data-title') : '';
      var activeDescription = activeSlide ? activeSlide.getAttribute('data-description') : '';
      var total = slideCount;
      var realIndex = typeof swiper.realIndex === 'number' ? swiper.realIndex : swiper.activeIndex;
      var progressWidth = total ? ((realIndex + 1) / total) * 100 : 0;

      if (title) {
        title.textContent = activeTitle || '';
      }

      if (description) {
        description.textContent = activeDescription || '';
      }

      if (progress) {
        progress.style.width = progressWidth + '%';
      }
    };

    new window.Swiper(slider, {
      slidesPerView: 'auto',
      spaceBetween: 12,
      loop: slideCount > 1,
      speed: 500,
      grabCursor: true,
      slideToClickedSlide: true,
      preventClicks: true,
      preventClicksPropagation: true,
      watchSlidesProgress: true,
      on: {
        init: updateActiveContent,
        slideChange: updateActiveContent,
      },
    });
  });
})();
