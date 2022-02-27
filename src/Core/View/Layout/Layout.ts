import './Layout.scss';
document.addEventListener("DOMContentLoaded", event => {
    const initEvent = new CustomEvent('init', {
        detail: {
            url: new URL(window.location.href, document.baseURI),
        }
    });
    document.dispatchEvent(initEvent);
});