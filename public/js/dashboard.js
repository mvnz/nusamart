// Mobile menu toggle
var mobileBtn = document.getElementById('mobileMenuBtn');
if (mobileBtn) {
    mobileBtn.addEventListener('click', function() {
        var nav = document.getElementById('mainNav');
        nav.classList.toggle('open');
    });
}

// User dropdown toggle (topbar)
var dropdownToggle = document.getElementById('userDropdownToggle');
if (dropdownToggle) {
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.parentElement.classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
        var dropdown = document.querySelector('.user-dropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });
}

// Nav user dropdown toggle (mobile navbar)
var navUserToggle = document.getElementById('navUserDropdownToggle');
if (navUserToggle) {
    navUserToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.parentElement.classList.toggle('open');
    });
}

// Cart dropdown toggle
var cartToggle = document.getElementById('cartToggle');
if (cartToggle) {
    cartToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.closest('.cart-summary').classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
        var cartSummary = document.querySelector('.cart-summary');
        if (cartSummary && !cartSummary.contains(e.target)) {
            cartSummary.classList.remove('open');
        }
    });
}

// Countdown timer
function startCountdown() {
    var endDate = new Date();
    endDate.setDate(endDate.getDate() + 2);
    endDate.setHours(endDate.getHours() + 10);

    function update() {
        var now = new Date();
        var diff = endDate - now;

        if (diff <= 0) {
            diff = 0;
        }

        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
        var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        var secs = Math.floor((diff % (1000 * 60)) / 1000);

        var daysEl = document.getElementById('days');
        var hoursEl = document.getElementById('hours');
        var minsEl = document.getElementById('mins');
        var secsEl = document.getElementById('secs');

        if (daysEl) daysEl.textContent = days < 10 ? '0' + days : days;
        if (hoursEl) hoursEl.textContent = hours < 10 ? '0' + hours : hours;
        if (minsEl) minsEl.textContent = mins < 10 ? '0' + mins : mins;
        if (secsEl) secsEl.textContent = secs < 10 ? '0' + secs : secs;
    }

    update();
    setInterval(update, 1000);
}

startCountdown();

// Product tab switching
document.querySelectorAll('.section-tabs a').forEach(function(tab) {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        var parent = this.closest('.section-tabs');
        parent.querySelectorAll('a').forEach(function(t) { t.classList.remove('active'); });
        this.classList.add('active');
    });
});

