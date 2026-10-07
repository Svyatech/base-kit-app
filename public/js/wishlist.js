(function () {
    var KEY = 'vg_wishlist';

    function read() {
        try {
            return JSON.parse(localStorage.getItem(KEY) || '[]');
        } catch (e) {
            return [];
        }
    }

    function write(list) {
        localStorage.setItem(KEY, JSON.stringify(list));
    }

    function has(id) {
        return read().indexOf(id) !== -1;
    }

    function toggle(id) {
        var list = read();
        var i = list.indexOf(id);
        if (i === -1) list.push(id); else list.splice(i, 1);
        write(list);
    }

    function sync() {
        var list = read();
        document.querySelectorAll('[data-wishlist]').forEach(function (btn) {
            btn.classList.toggle('is-active', list.indexOf(btn.dataset.wishlist) !== -1);
        });
        document.querySelectorAll('.wishlist-count').forEach(function (el) {
            el.textContent = list.length;
            el.hidden = list.length === 0;
        });
    }

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-wishlist]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        toggle(btn.dataset.wishlist);
        sync();
    });

    document.addEventListener('DOMContentLoaded', sync);

    window.wishlist = { read: read, has: has, sync: sync };
})();
