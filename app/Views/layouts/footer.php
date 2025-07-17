<footer class="bg-white border-t border-gray-200 py-4 text-center text-gray-500 text-sm">
    © 2024 Sembako Inventory. All rights reserved.
</footer>
<script>
const userMenuButton = document.getElementById('userMenuButton');
const userDropdown = document.getElementById('userDropdown');

userMenuButton?.addEventListener('click', () => {
    const isHidden = userDropdown.classList.contains('hidden');
    if (isHidden) {
        userDropdown.classList.remove('hidden');
        userMenuButton.setAttribute('aria-expanded', 'true');
    } else {
        userDropdown.classList.add('hidden');
        userMenuButton.setAttribute('aria-expanded', 'false');
    }
});

window.addEventListener('click', (e) => {
    if (!userMenuButton?.contains(e.target) && !userDropdown?.contains(e.target)) {
        userDropdown?.classList.add('hidden');
        userMenuButton?.setAttribute('aria-expanded', 'false');
    }
});
</script>
</body>

</html>