// Admin-only bundle: the Trix rich-text editor for project descriptions.
import 'trix';
import 'trix/dist/trix.css';

// Uploading files through the editor isn't supported (use the gallery instead).
document.addEventListener('trix-file-accept', (event) => event.preventDefault());

document.addEventListener('trix-initialize', (event) => {
    event.target.toolbarElement
        ?.querySelector('[data-trix-button-group="file-tools"]')
        ?.remove();
});
