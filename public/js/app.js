/* ================================================================
   CHANCHULLAPP v4 — JavaScript Core
   Loader · Mouse Glow · Dropzone · Scan · Counters · Charts · Canasta
   ================================================================ */

(function () {
    'use strict';

    /* ── Page Loader ── */
    const loader = document.getElementById('page-loader');
    function showLoader() {
        if (!loader) return;
        loader.classList.add('active');
    }
    function hideLoader() {
        if (!loader) return;
        loader.classList.remove('active');
    }

    document.addEventListener('click', function (e) {
        const a = e.target.closest('a');
        if (!a) return;
        const href = a.getAttribute('href');
        const target = a.getAttribute('target');
        if (!href || href.startsWith('#') || target === '_blank') return;
        try {
            const url = new URL(href, location.origin);
            if (url.origin !== location.origin) return;
        } catch (_) { return; }
        e.preventDefault();
        showLoader();
        setTimeout(function () { location.href = href; }, 380);
    });

    window.addEventListener('load', hideLoader);

    /* ── Navbar Scroll ── */
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('navbar--scrolled', window.scrollY > 30);
        }, { passive: true });
    }

    /* ── Mobile Menu ── */
    var hamburger = document.getElementById('nav-hamburger');
    var mobileOverlay = document.getElementById('mobile-overlay');
    if (hamburger && mobileOverlay) {
        hamburger.addEventListener('click', function () {
            hamburger.classList.toggle('open');
            mobileOverlay.classList.toggle('open');
            document.body.style.overflow = mobileOverlay.classList.contains('open') ? 'hidden' : '';
        });
        mobileOverlay.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                hamburger.classList.remove('open');
                mobileOverlay.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }

    /* ── Mouse Glow ── */
    var mouseGlow = document.querySelector('.mouse-glow');
    if (mouseGlow) {
        document.addEventListener('mousemove', function (e) {
            mouseGlow.style.left = e.clientX + 'px';
            mouseGlow.style.top = e.clientY + 'px';
        });
    }

    /* ── Floating Particles (pure CSS, no lag) ── */
    var particlesEl = document.getElementById('particles');
    if (particlesEl) {
        var colors = ['rgba(0,245,212,', 'rgba(123,97,255,', 'rgba(255,107,157,'];
        for (var i = 0; i < 30; i++) {
            var p = document.createElement('div');
            p.className = 'particle';
            var size = Math.random() * 3 + 1;
            var color = colors[i % 3];
            var alpha = (Math.random() * 0.4 + 0.1).toFixed(2);
            p.style.width = size + 'px';
            p.style.height = size + 'px';
            p.style.left = Math.random() * 100 + '%';
            p.style.bottom = -(Math.random() * 20) + '%';
            p.style.background = color + alpha + ')';
            p.style.boxShadow = '0 0 ' + (size * 3) + 'px ' + color + (alpha * 0.6) + ')';
            p.style.animationDuration = (Math.random() * 15 + 12) + 's';
            p.style.animationDelay = (Math.random() * 1.5) + 's';
            particlesEl.appendChild(p);
        }
    }

    /* ── Scroll Reveal ── */
    var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function (el) { revealObserver.observe(el); });

    /* ── Dropzone ── */
    var dropzone = document.getElementById('dropzone');
    var fileInput = document.getElementById('file-input');
    if (dropzone && fileInput) {
        dropzone.addEventListener('click', function () { fileInput.click(); });
        ['dragenter', 'dragover'].forEach(function (ev) {
            dropzone.addEventListener(ev, function (e) { e.preventDefault(); dropzone.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            dropzone.addEventListener(ev, function (e) { e.preventDefault(); dropzone.classList.remove('dragover'); });
        });
        dropzone.addEventListener('drop', function (e) {
            var f = e.dataTransfer.files;
            if (f && f[0]) handleFile(f[0]);
        });
        fileInput.addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) handleFile(e.target.files[0]);
        });
        function handleFile(file) {
            if (!file.type.startsWith('image/')) { alert('Seleccioná una imagen válida.'); return; }
            var reader = new FileReader();
            reader.onload = function (ev) {
                var img = dropzone.querySelector('.dropzone-preview');
                if (img) { img.src = ev.target.result; img.style.display = 'block'; }
                dropzone.classList.add('has-file');
                startScan();
            };
            reader.readAsDataURL(file);
        }
        function startScan() {
            var overlay = document.getElementById('scan-overlay');
            var bar = document.querySelector('.scan-progress-bar');
            var status = document.querySelector('.scan-status');
            if (!overlay) return;
            overlay.classList.add('active');
            var pct = 0;
            var msgs = [
                'Preprocesando imagen...', 'Detectando texto (OCR)...', 'Normalizando productos...',
                'Consultando precios...', 'Calculando ahorro...', '¡Listo!'
            ];
            var iv = setInterval(function () {
                pct += Math.random() * 6 + 2;
                if (pct >= 100) {
                    pct = 100;
                    clearInterval(iv);
                    if (status) status.textContent = msgs[msgs.length - 1];
                    setTimeout(function () { location.href = '/dashboard'; }, 700);
                }
                if (bar) bar.style.width = pct + '%';
                if (status) status.textContent = msgs[Math.min(Math.floor(pct / 20), msgs.length - 1)];
            }, 180);
        }
    }

    /* ── Counter Animation ── */
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseFloat(el.getAttribute('data-count'));
        var prefix = el.getAttribute('data-prefix') || '';
        var suffix = el.getAttribute('data-suffix') || '';
        var decimals = (el.getAttribute('data-decimals') || '0') | 0;
        var duration = 1800;
        var start = null;
        var observed = false;

        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var ease = 1 - Math.pow(1 - p, 3);
            var val = target * ease;
            el.textContent = prefix + val.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix;
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = prefix + target.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix;
        }

        var obs = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting && !observed) {
                observed = true;
                requestAnimationFrame(step);
                obs.unobserve(el);
            }
        }, { threshold: 0.3 });
        obs.observe(el);
    });

    /* ── Canasta Search & Filter ── */
    var canastaSearch = document.getElementById('canasta-search');
    var canastaFilters = document.getElementById('canasta-filters');
    var canastaEmpty = document.getElementById('canasta-empty');
    var activeCat = 'todos';

    function filterCanasta() {
        if (!canastaForm) return;
        var q = canastaSearch ? canastaSearch.value.toLowerCase().trim() : '';
        var visible = 0;
        canastaForm.querySelectorAll('.check-item').forEach(function (item) {
            var name = (item.getAttribute('data-name') || '').toLowerCase();
            var cat = item.getAttribute('data-cat') || '';
            var matchSearch = !q || name.includes(q);
            var matchCat = activeCat === 'todos' || cat === activeCat;
            var show = matchSearch && matchCat;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (canastaEmpty) canastaEmpty.style.display = visible === 0 ? 'block' : 'none';
    }

    if (canastaSearch) canastaSearch.addEventListener('input', filterCanasta);

    if (canastaFilters) {
        canastaFilters.querySelectorAll('.cat-filter').forEach(function (btn) {
            btn.addEventListener('click', function () {
                canastaFilters.querySelectorAll('.cat-filter').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeCat = btn.getAttribute('data-cat');
                filterCanasta();
            });
        });
    }

    /* ── Canasta Calculator ── */
    var canastaForm = document.getElementById('canasta-form');
    var canastaTotal = document.getElementById('canasta-total');
    var canastaTotalBs = document.getElementById('canasta-total-bs');
    var BS_RATE = 592.52;
    if (canastaForm && canastaTotal) {
        var items = canastaForm.querySelectorAll('.check-item');
        var pieChartEl = document.getElementById('pieChart');

        function updateTotal() {
            var total = 0;
            var proteinas = 0;
            var carbohidratos = 0;
            items.forEach(function (item) {
                if (item.classList.contains('checked')) {
                    var price = parseFloat(item.getAttribute('data-price')) || 0;
                    var cat = item.getAttribute('data-cat') || 'carbohidratos';
                    total += price;
                    if (cat === 'proteinas') proteinas += price;
                    else carbohidratos += price;
                }
            });
            animateValue(canastaTotal, total);
            if (canastaTotalBs) canastaTotalBs.textContent = 'Bs ' + (total * BS_RATE).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            updatePie(proteinas, carbohidratos);
        }

        items.forEach(function (item) {
            item.addEventListener('click', function () {
                item.classList.toggle('checked');
                var box = item.querySelector('.check-box');
                if (box) box.textContent = item.classList.contains('checked') ? '\u2713' : '';
                updateTotal();
            });
        });

        function animateValue(el, target) {
            var start = parseFloat(el.textContent.replace(/[^0-9.]/g, '')) || 0;
            var startTime = null;
            var dur = 500;
            function step(ts) {
                if (!startTime) startTime = ts;
                var p = Math.min((ts - startTime) / dur, 1);
                var ease = 1 - Math.pow(1 - p, 3);
                var val = start + (target - start) * ease;
                el.textContent = '$' + val.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        /* Pie Chart (Chart.js) */
        var pieChart = null;
        function updatePie(proteinas, carbohidratos) {
            if (!pieChartEl || typeof Chart === 'undefined') return;
            if (!pieChart) {
                pieChart = new Chart(pieChartEl.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Proteínas', 'Carbohidratos'],
                        datasets: [{
                            data: [proteinas, carbohidratos],
                            backgroundColor: ['rgba(0,245,212,0.7)', 'rgba(123,97,255,0.7)'],
                            borderColor: ['rgba(0,245,212,1)', 'rgba(123,97,255,1)'],
                            borderWidth: 2,
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.5)', padding: 16, font: { size: 12 } } }
                        }
                    }
                });
            } else {
                pieChart.data.datasets[0].data = [proteinas, carbohidratos];
                pieChart.update();
            }
        }
        updateTotal();
    }

    /* ── Profile Line Chart ── */
    var lineChartEl = document.getElementById('activityChart');
    if (lineChartEl && typeof Chart !== 'undefined') {
        new Chart(lineChartEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Facturas escaneadas',
                    data: [2, 1, 3, 0, 4, 2, 1],
                    borderColor: '#00f5d4',
                    backgroundColor: 'rgba(0,245,212,0.08)',
                    fill: true, tension: 0.4,
                    pointBackgroundColor: '#00f5d4',
                    pointBorderColor: '#06060f', pointBorderWidth: 2,
                    pointRadius: 5, pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: {
                    x: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: 'rgba(255,255,255,0.3)', font: { size: 11 } } },
                    y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: 'rgba(255,255,255,0.3)', font: { size: 11 }, stepSize: 1 }, beginAtZero: true }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    /* ── Search Filter ── */
    var searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.gtable tbody tr').forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }

})();
