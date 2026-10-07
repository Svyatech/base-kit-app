(function () {
    var el = document.getElementById('city-map');
    if (!el) return;

    var key = el.dataset.ykey || '';
    if (!key) return;

    var PIN_COLORS = {
        beach: '#0e7c7b',
        market: '#e4572e',
        attraction: '#5b5ea6',
        food: '#2c7a4b'
    };

    function loadApi(cb) {
        if (window.ymaps) return ymaps.ready(cb);
        var s = document.createElement('script');
        s.src = 'https://api-maps.yandex.ru/2.1/?apikey=' + encodeURIComponent(key) + '&lang=ru_RU';
        s.async = true;
        s.onload = function () { ymaps.ready(cb); };
        document.body.appendChild(s);
    }

    function googleUrl(m) {
        return 'https://www.google.com/maps/search/?api=1&query=' + m.lat + ',' + m.lng;
    }

    function init() {
        var markers = JSON.parse(el.dataset.markers || '[]');
        var zones = JSON.parse(el.dataset.zones || '[]');
        var center = JSON.parse(el.dataset.center || '[12.2388, 109.1967]');
        var zoom = parseInt(el.dataset.zoom || '13', 10);

        var map = new ymaps.Map(el, {
            center: center,
            zoom: zoom,
            controls: ['zoomControl']
        }, {
            suppressMapOpenBlock: true,
            yandexMapDisablePoiInteractivity: true
        });

        map.behaviors.disable('scrollZoom');

        var layers = [];

        markers.forEach(function (m) {
            var url = m.url || googleUrl(m);
            var cta = el.dataset.cta || 'Google Maps \u2192';
            var wishlistAria = el.dataset.wishlistAria || '';
            var img = m.img
                ? '<img class="map-popup-img" src="' + m.img + '" alt="' + m.name + '" loading="lazy">'
                : '';
            var rating = m.rating
                ? '<div class="map-popup-rating">★ ' + m.rating + ' · ' + m.reviews.toLocaleString('ru-RU') + ' ' + (el.dataset.reviews || '') + '</div>'
                : '';
            var placemark = new ymaps.Placemark([m.lat, m.lng], {
                hintContent: m.name,
                balloonContentHeader: '<b>' + m.name + '</b>',
                balloonContentBody: img + '<span class="map-popup-meta">' + m.meta + '</span>' + rating,
                balloonContentFooter: '<button type="button" class="wishlist-btn wishlist-btn--sm" data-wishlist="' + m.id + '" aria-label="' + wishlistAria + '"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></button> <a class="map-ym-cta" href="' + url + '" target="_blank" rel="noopener">' + cta + '</a>'
            }, {
                preset: 'islands#circleIcon',
                iconColor: PIN_COLORS[m.type] || PIN_COLORS.beach,
                balloonMaxWidth: 240
            });

            placemark.placeType = m.type;
            placemark.events.add('balloonopen', function () {
                if (window.wishlist) window.wishlist.sync();
            });
            map.geoObjects.add(placemark);
            layers.push(placemark);
        });

        document.querySelectorAll('.map-chip[data-type]').forEach(function (chip) {
            chip.addEventListener('click', function () {
                document.querySelectorAll('.map-chip[data-type]').forEach(function (c) { c.classList.remove('is-active'); });
                chip.classList.add('is-active');
                map.balloon.close();

                var type = chip.dataset.type;
                layers.forEach(function (placemark) {
                    if (type === 'all' || placemark.placeType === type) {
                        map.geoObjects.add(placemark);
                    } else {
                        map.geoObjects.remove(placemark);
                    }
                });
            });
        });

        var zoneToggle = document.getElementById('map-zones-toggle');
        var zoneCircles = [];
        var zonesOn = false;

        zones.forEach(function (z) {
            var circle = new ymaps.Circle([[z.lat, z.lng], z.radius], {
                hintContent: z.name,
                balloonContentHeader: '<b>' + z.name + '</b>',
                balloonContentBody: '<span class="map-popup-meta">' + z.desc + '</span>'
            }, {
                fillColor: z.color + '22',
                strokeColor: z.color,
                strokeWidth: 2,
                interactivityModel: 'default#opaque'
            });
            zoneCircles.push(circle);
        });

        if (zoneToggle) {
            zoneToggle.addEventListener('click', function () {
                zonesOn = !zonesOn;
                zoneToggle.classList.toggle('is-active', zonesOn);
                map.balloon.close();
                zoneCircles.forEach(function (c) {
                    if (zonesOn) map.geoObjects.add(c); else map.geoObjects.remove(c);
                });
            });
        }
    }

    function boot() {
        loadApi(init);
    }

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                observer.disconnect();
                boot();
            }
        }, { rootMargin: '300px' });
        observer.observe(el);
    } else {
        boot();
    }
})();
