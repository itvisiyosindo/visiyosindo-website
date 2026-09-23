/**
 * Quill Editor Module
 * Initialize Quill rich text editor with custom configuration
 */

import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Make Quill available globally for inline scripts
window.Quill = Quill;

/**
 * Initialize Quill Editor with image upload
 * @param {string} selector - CSS selector for editor container
 * @param {string} textareaId - ID of hidden textarea to sync content
 * @param {string} uploadUrl - URL for image upload endpoint
 * @param {string} csrfToken - CSRF token for uploads
 * @returns {Quill} Quill instance
 */
export function initQuillEditor(selector, textareaId, uploadUrl, csrfToken) {
    const editorContainer = document.querySelector(selector);
    const contentTextarea = document.getElementById(textareaId);
    
    if (!editorContainer || !contentTextarea) {
        console.error('Quill editor elements not found:', { selector, textareaId });
        return null;
    }

    // Quill configuration
    const quill = new Quill(selector, {
        theme: 'snow',
        placeholder: 'Tulis konten di sini...',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ],
                handlers: {
                    image: function() {
                        imageHandler(quill, uploadUrl, csrfToken);
                    }
                }
            }
        }
    });

    // Set initial content
    const initialContent = contentTextarea.value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }

    // Update hidden textarea on content change
    quill.on('text-change', function() {
        contentTextarea.value = quill.root.innerHTML;
    });

    // Form submit handler - ensure content is synced
    const form = editorContainer.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            contentTextarea.value = quill.root.innerHTML;
        });
    }

    return quill;
}

/**
 * Custom image upload handler for Quill
 */
function imageHandler(quill, uploadUrl, csrfToken) {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();

    input.onchange = async function() {
        const file = input.files[0];
        if (!file) return;

        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 5MB');
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar');
            return;
        }

        // Show loading state
        const range = quill.getSelection() || { index: quill.getLength() };
        quill.insertText(range.index, 'Uploading image...');

        try {
            // Upload image
            const formData = new FormData();
            formData.append('file', file);

            const response = await fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Upload failed: ' + response.statusText);
            }

            const data = await response.json();
            
            if (data.location) {
                // Remove loading text
                quill.deleteText(range.index, 'Uploading image...'.length);
                // Insert uploaded image
                quill.insertEmbed(range.index, 'image', data.location);
                quill.setSelection(range.index + 1);
            } else {
                throw new Error('Invalid response from server');
            }
        } catch (error) {
            console.error('Image upload error:', error);
            alert('Gagal upload gambar: ' + error.message);
            // Remove loading text on error
            const text = quill.getText();
            const loadingText = 'Uploading image...';
            const loadingIndex = text.indexOf(loadingText);
            if (loadingIndex !== -1) {
                quill.deleteText(loadingIndex, loadingText.length);
            }
        }
    };
}

export default Quill;
