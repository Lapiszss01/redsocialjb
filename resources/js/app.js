import './bootstrap';


import Alpine from 'alpinejs';

import Dropzone from "dropzone";

window.Alpine = Alpine;

Alpine.start();

function redirectToRoute(event, route) {
    const target = event.target;

    // Verifica si el clic no fue en un enlace o botón
    if (!target.closest('a') && !target.closest('button')) {
        window.location.href = route;
    }
}
