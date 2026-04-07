import './bootstrap';

const existingFavicon = document.querySelector("link[rel='icon']");

if (existingFavicon) {
    existingFavicon.setAttribute('href', 'data:,');
} else {
    const favicon = document.createElement('link');
    favicon.setAttribute('rel', 'icon');
    favicon.setAttribute('href', 'data:,');
    document.head.appendChild(favicon);
}
