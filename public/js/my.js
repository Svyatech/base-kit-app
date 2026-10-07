(function () {
    var el = document.getElementById('my-list');
    if (!el || !window.wishlist) return;

    var places = JSON.parse(el.dataset.places || '[]');
    var byId = {};
    places.forEach(function (p) { byId[p.id] = p; });

    var googleLabel = el.dataset.google || 'Google Maps \u2192';
    var wishlistAria = el.dataset.wishlistAria || '';
    var reviewsLabel = el.dataset.reviews || '';

    var articlesEl = document.getElementById('my-articles');
    var articlesWrap = document.getElementById('my-articles-wrap');
    var articles = JSON.parse(articlesEl.dataset.articles || '[]');
    var articlesById = {};
    articles.forEach(function (a) { articlesById[a.id] = a; });

    function importFromUrl() {
        var params = new URLSearchParams(location.search);
        var list = params.get('list');
        if (!list) return;
        list.split(',').forEach(function (id) {
            if (byId[id] && !window.wishlist.has(id)) {
                var cur = window.wishlist.read();
                cur.push(id);
                localStorage.setItem('vg_wishlist', JSON.stringify(cur));
            }
        });
        history.replaceState(null, '', location.pathname);
        window.wishlist.sync();
    }

    function render() {
        var saved = window.wishlist.read();
        var ids = saved.filter(function (id) { return byId[id]; });
        var articleIds = saved.filter(function (id) { return articlesById[id]; });
        var empty = document.getElementById('my-empty');
        var share = document.getElementById('my-share');

        el.innerHTML = '';
        articlesEl.innerHTML = '';
        empty.hidden = (ids.length + articleIds.length) > 0;
        articlesWrap.hidden = articleIds.length === 0;
        share.disabled = saved.length === 0;

        articleIds.forEach(function (id) {
            var a = articlesById[id];
            var card = document.createElement('div');
            card.className = 'my-card my-card--article';
            card.innerHTML =
                '<div class="my-card-body">' +
                    '<a class="my-card-name" href="' + a.url + '">' + a.title + '</a>' +
                    '<div class="map-popup-meta">' + a.text + '</div>' +
                    '<div class="my-card-actions">' +
                        '<button type="button" class="wishlist-btn wishlist-btn--sm is-active" data-wishlist="' + a.id + '" aria-label="' + wishlistAria + '">' +
                            '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            articlesEl.appendChild(card);
        });

        ids.forEach(function (id) {
            var p = byId[id];
            var card = document.createElement('div');
            card.className = 'my-card';
            card.innerHTML =
                '<img class="my-card-img" src="' + p.img + '" alt="' + p.name + '" loading="lazy">' +
                '<div class="my-card-body">' +
                    '<div class="my-card-name">' + p.name + '</div>' +
                    '<div class="map-popup-meta">' + p.meta + '</div>' +
                    (p.rating ? '<div class="map-popup-rating">★ ' + p.rating + ' · ' + p.reviews.toLocaleString('ru-RU') + ' ' + reviewsLabel + '</div>' : '') +
                    '<div class="my-card-actions">' +
                        '<a class="map-ym-cta" href="' + p.url + '" target="_blank" rel="noopener">' + googleLabel + '</a>' +
                        '<button type="button" class="wishlist-btn wishlist-btn--sm is-active" data-wishlist="' + p.id + '" aria-label="' + wishlistAria + '">' +
                            '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            el.appendChild(card);
        });

        window.wishlist.sync();
    }

    document.getElementById('my-share').addEventListener('click', function () {
        var ids = window.wishlist.read();
        var url = location.origin + location.pathname + '?list=' + ids.join(',');
        var label = this.querySelector('span');
        var shareLabel = this.dataset.label;
        var copiedLabel = this.dataset.copied;
        navigator.clipboard.writeText(url).then(function () {
            label.textContent = copiedLabel;
            setTimeout(function () { label.textContent = shareLabel; }, 2000);
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-wishlist]')) setTimeout(render, 0);
    });

    importFromUrl();
    render();
})();
