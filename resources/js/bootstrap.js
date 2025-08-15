import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add CSRF token to all requests
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Fallback: Check if Laravel object is available
if (window.Laravel && window.Laravel.csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
}

// Add request interceptor to handle CSRF token refresh
window.axios.interceptors.request.use(function (config) {
    // If we don't have a CSRF token, try to get it from the meta tag
    if (!config.headers['X-CSRF-TOKEN']) {
        const metaToken = document.head.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            config.headers['X-CSRF-TOKEN'] = metaToken.content;
        }
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

// Add response interceptor to handle 419 errors
window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response && error.response.status === 419) {
        console.error('CSRF token mismatch. Please refresh the page.');
        // Optionally refresh the page
        // window.location.reload();
    }
    return Promise.reject(error);
});
