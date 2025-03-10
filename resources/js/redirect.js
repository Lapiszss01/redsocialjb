export function redirectToRoute(event, route) {
    const target = event.target;

    if (!target.closest('a') && !target.closest('button')) {
        window.location.href = route;
    }
}
