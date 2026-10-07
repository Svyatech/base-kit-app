(function () {
    var el = document.getElementById('converter');
    if (!el) return;

    var vndPerUsd = parseFloat(el.dataset.vndUsd);
    var rubPerUsd = parseFloat(el.dataset.rubUsd);
    var inputs = {
        vnd: el.querySelector('[data-cur="vnd"]'),
        rub: el.querySelector('[data-cur="rub"]'),
        usd: el.querySelector('[data-cur="usd"]')
    };
    var lock = false;

    function round(value, decimals) {
        var f = Math.pow(10, decimals);
        return Math.round(value * f) / f;
    }

    function fromVnd(vnd) {
        var usd = vnd / vndPerUsd;
        inputs.usd.value = vnd === '' ? '' : round(usd, 2);
        inputs.rub.value = vnd === '' ? '' : Math.round(usd * rubPerUsd);
    }

    function recalc(source) {
        if (lock) return;
        lock = true;
        var v = parseFloat(inputs[source].value);
        if (inputs[source].value === '' || isNaN(v)) {
            ['vnd', 'rub', 'usd'].forEach(function (k) {
                if (k !== source) inputs[k].value = '';
            });
        } else if (source === 'vnd') {
            fromVnd(v);
        } else if (source === 'usd') {
            inputs.vnd.value = Math.round(v * vndPerUsd);
            inputs.rub.value = Math.round(v * rubPerUsd);
        } else {
            var usd = v / rubPerUsd;
            inputs.vnd.value = Math.round(usd * vndPerUsd);
            inputs.usd.value = round(usd, 2);
        }
        lock = false;
    }

    ['vnd', 'rub', 'usd'].forEach(function (k) {
        inputs[k].addEventListener('input', function () { recalc(k); });
    });

    el.querySelectorAll('[data-chip]').forEach(function (chip) {
        chip.addEventListener('click', function () {
            inputs.vnd.value = chip.dataset.chip;
            recalc('vnd');
        });
    });

    recalc('vnd');
})();
