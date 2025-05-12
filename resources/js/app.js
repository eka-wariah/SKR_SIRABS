import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const user = window.loggedInUser;
    const roles = user?.roles?.map(role => role.name) || [];

    if (!roles.includes('treasurer')) {
        document.getElementById('menu-kelola-bendahara')?.remove();
    }

    if (!roles.includes('wastebank_officer')) {
        document.getElementById('menu-bank-sampah')?.remove();
    }
});
