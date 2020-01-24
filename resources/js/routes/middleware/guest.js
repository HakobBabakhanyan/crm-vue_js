// src/middleware/guest.js
export default function auth({ next, router }) {
    if (localStorage.getItem('jwt')) {
        return router.push({ name: 'dashboard' });
    }
    return next();
}
