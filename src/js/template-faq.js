(function () {
  const page = document.querySelector('[data-faq-page]');

  if (!page || typeof faqAjax === 'undefined') {
    return;
  }

  const input = page.querySelector('[data-faq-search]');
  const list = page.querySelector('[data-faq-list]');
  const results = page.querySelector('[data-faq-results]');
  const loading = page.querySelector('[data-faq-loading]');
  const title = page.querySelector('[data-faq-section-title]');
  const suggestions = page.querySelector('[data-faq-suggestions]');
  const filters = Array.from(page.querySelectorAll('[data-term-id]'));

  let selectedTerm = 0;
  let activeRequest = null;
  let timer = null;
  let lastKey = '';
  let showSuggestionsOnNextResponse = true;
  let activeSuggestionIndex = -1;
  const cache = {};

  function debounce(callback, delay) {
    return function () {
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  }

  function closeSuggestions() {
    if (!suggestions) {
      return;
    }

    suggestions.hidden = true;
    suggestions.innerHTML = '';
    activeSuggestionIndex = -1;
  }

  function setSuggestionLoading(isLoading) {
    if (!suggestions) {
      return;
    }

    if (!isLoading) {
      return;
    }

    suggestions.innerHTML = '<div class="faq-search__state"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>Đang tìm...</span></div>';
    suggestions.hidden = false;
  }

  function setLoading(isLoading) {
    if (!results) {
      return;
    }

    results.setAttribute('aria-busy', isLoading ? 'true' : 'false');
    results.classList.toggle('is-loading', isLoading);

    if (loading) {
      loading.hidden = !isLoading;
    }
  }

  function setFilterState(matchedTerms, matchedCounts) {
    const hasKeyword = Boolean(input && input.value.trim());

    filters.forEach(function (filter) {
      const termId = parseInt(filter.getAttribute('data-term-id') || '0', 10);
      const count = matchedCounts && matchedCounts[termId] ? matchedCounts[termId] : 0;
      const countEl = filter.querySelector('[data-filter-count]');
      const shouldDisable = hasKeyword && termId !== 0 && count === 0;

      filter.classList.toggle('is-active', termId === selectedTerm);
      filter.classList.toggle(
        'is-matched',
        matchedTerms.indexOf(termId) !== -1 && termId !== selectedTerm && termId !== 0
      );
      filter.disabled = shouldDisable;

      if (countEl) {
        countEl.textContent = count;
        countEl.hidden = count === 0;
      }
    });
  }

  function bindAccordion() {
    const items = Array.from(page.querySelectorAll('[data-faq-item]'));

    items.forEach(function (item) {
      const panel = item.querySelector('.faq-item__panel');

      if (!panel) {
        return;
      }

      item.classList.toggle('is-open', panel.classList.contains('show'));

      panel.addEventListener('shown.bs.collapse', function () {
        item.classList.add('is-open');
      });

      panel.addEventListener('hidden.bs.collapse', function () {
        item.classList.remove('is-open');
      });
    });
  }

  function renderSuggestions(items) {
    if (!suggestions) {
      return;
    }

    if (!showSuggestionsOnNextResponse || !input.value.trim()) {
      closeSuggestions();
      showSuggestionsOnNextResponse = true;
      return;
    }

    if (!items.length) {
      suggestions.innerHTML = '<div class="faq-search__state">Không tìm thấy câu hỏi phù hợp</div>';
      suggestions.hidden = false;
      return;
    }

    suggestions.innerHTML = '';

    items.forEach(function (item) {
      const button = document.createElement('button');
      const icon = document.createElement('i');
      const label = document.createElement('span');

      button.className = 'faq-search__suggestion';
      button.type = 'button';
      button.dataset.suggestion = item.title;
      button.dataset.suggestionId = item.id;

      icon.className = 'fa-regular fa-circle-question';
      icon.setAttribute('aria-hidden', 'true');
      label.textContent = item.title;

      button.appendChild(icon);
      button.appendChild(label);
      suggestions.appendChild(button);
    });

    suggestions.hidden = false;
    activeSuggestionIndex = -1;

    Array.from(suggestions.querySelectorAll('[data-suggestion]')).forEach(function (button) {
      button.addEventListener('click', function () {
        input.value = button.getAttribute('data-suggestion') || '';
        showSuggestionsOnNextResponse = false;
        closeSuggestions();
        loadFaq('search', true);
      });
    });
  }

  function getSuggestionButtons() {
    if (!suggestions || suggestions.hidden) {
      return [];
    }

    return Array.from(suggestions.querySelectorAll('[data-suggestion]'));
  }

  function setActiveSuggestion(index) {
    const buttons = getSuggestionButtons();

    if (!buttons.length) {
      activeSuggestionIndex = -1;
      return;
    }

    if (index < 0) {
      activeSuggestionIndex = buttons.length - 1;
    } else if (index >= buttons.length) {
      activeSuggestionIndex = 0;
    } else {
      activeSuggestionIndex = index;
    }

    buttons.forEach(function (button, buttonIndex) {
      const isActive = buttonIndex === activeSuggestionIndex;

      button.classList.toggle('is-highlighted', isActive);

      if (isActive) {
        button.scrollIntoView({
          block: 'nearest'
        });
      }
    });
  }

  function chooseActiveSuggestion() {
    const buttons = getSuggestionButtons();

    if (activeSuggestionIndex < 0 || !buttons[activeSuggestionIndex]) {
      return false;
    }

    buttons[activeSuggestionIndex].click();
    return true;
  }

  function focusFaqItem(itemId) {
    const item = page.querySelector('[data-faq-id="' + itemId + '"]');

    if (!item) {
      loadFaq('search', true);
      return;
    }

    const panel = item.querySelector('.faq-item__panel');

    if (panel && typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
      bootstrap.Collapse.getOrCreateInstance(panel, {
        toggle: false
      }).show();
    }

    item.scrollIntoView({
      behavior: 'smooth',
      block: 'nearest'
    });
  }

  function applyResponse(data) {
    if (data.include_items && title) {
      title.textContent = data.section_title || '';
    }

    if (data.include_items && list) {
      list.innerHTML = data.items_html || '';
    }

    setFilterState(data.matched_terms || [], data.matched_term_counts || {});
    renderSuggestions(data.suggestions || []);

    if (data.include_items) {
      bindAccordion();
    }
  }

  function loadFaq(mode, force) {
    const keyword = input ? input.value.trim() : '';
    const key = mode + '|' + keyword + '|' + selectedTerm;

    if (!force && key === lastKey) {
      return;
    }

    lastKey = key;

    if (cache[key]) {
      applyResponse(cache[key]);
      return;
    }

    if (activeRequest) {
      activeRequest.abort();
    }

    activeRequest = new AbortController();

    const form = new FormData();
    form.append('action', 'paint_filter_faq');
    form.append('nonce', faqAjax.nonce);
    form.append('keyword', keyword);
    form.append('term_id', String(selectedTerm));
    form.append('mode', mode);

    if (mode === 'search') {
      setLoading(true);
    } else if (mode === 'suggest') {
      setSuggestionLoading(true);
    }

    fetch(faqAjax.url, {
      method: 'POST',
      body: form,
      signal: activeRequest.signal
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        if (!response || !response.success) {
          return;
        }

        cache[key] = response.data;
        applyResponse(response.data);
      })
      .catch(function (error) {
        if (error.name !== 'AbortError') {
          closeSuggestions();
        }
      })
      .finally(function () {
        if (mode === 'search') {
          setLoading(false);
        }
      });
  }

  filters.forEach(function (filter) {
    filter.addEventListener('click', function () {
      selectedTerm = parseInt(filter.getAttribute('data-term-id') || '0', 10);
      clearTimeout(timer);
      showSuggestionsOnNextResponse = false;
      setFilterState([], {});
      closeSuggestions();
      loadFaq('search', true);
    });
  });

  if (input) {
    input.addEventListener('input', debounce(function () {
      if (!input.value.trim()) {
        selectedTerm = 0;
        closeSuggestions();
        setFilterState([], {});
        showSuggestionsOnNextResponse = false;
        loadFaq('search', true);
        return;
      }

      selectedTerm = 0;
      showSuggestionsOnNextResponse = true;
      setFilterState([], {});
      loadFaq('suggest', false);
    }, 300));

    input.addEventListener('keydown', function (event) {
      if (event.key === 'ArrowDown') {
        event.preventDefault();
        setActiveSuggestion(activeSuggestionIndex + 1);
        return;
      }

      if (event.key === 'ArrowUp') {
        event.preventDefault();
        setActiveSuggestion(activeSuggestionIndex - 1);
        return;
      }

      if (event.key === 'Escape') {
        closeSuggestions();
        return;
      }

      if (event.key !== 'Enter') {
        return;
      }

      event.preventDefault();

      if (chooseActiveSuggestion()) {
        return;
      }

      clearTimeout(timer);
      showSuggestionsOnNextResponse = false;
      closeSuggestions();
      loadFaq('search', true);
    });

    input.addEventListener('focus', function () {
      if (input.value.trim()) {
        showSuggestionsOnNextResponse = true;
        loadFaq('suggest', false);
      }
    });

    document.addEventListener('click', function (event) {
      if (!event.target.closest('.faq-search')) {
        closeSuggestions();
      }
    });
  }

  bindAccordion();
})();
