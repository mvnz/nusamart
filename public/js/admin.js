// Sidebar toggle (mobile)
var sidebarToggle = document.getElementById('sidebarToggle');
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function() {
        var sidebar = document.getElementById('adminSidebar');
        sidebar.classList.toggle('open');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        var sidebar = document.getElementById('adminSidebar');
        if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
            sidebar.classList.remove('open');
        }
    });
}
