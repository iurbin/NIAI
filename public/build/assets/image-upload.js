const form = document.getElementById('uploadForm');
const output = document.getElementById('output');
const imagePreview = document.getElementById('image-preview');
const imageCoverPreview = document.getElementById('cover');
const uploadedImage = document.getElementById('uploaded-image');
const errorText = document.getElementById('error-text');
const submitBtn = document.getElementById('submitBtn');
const uploadURL = document.getElementById('image_upload_url').value;
const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

form.addEventListener('submit', async function(e) {
    e.preventDefault(); // Stop page reload

    // clear previous errors/success
    output.classList.add('d-none');
    errorText.classList.add('d-none');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Uploading...';

    // Create FormData object (handles file data automatically)
    const formData = new FormData(this);
    
    try {
        const response = await fetch(uploadURL, {
            method: 'POST',
            headers: {
                // Laravel requires this header for AJAX POST requests
                /* 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') */
                'X-CSRF-TOKEN': csrf
            },
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            // Handle Validation Errors
            throw data; 
        }

        // Success Logic
        output.innerHTML = `<div class="badge bg-info my-2 rounded mx-auto"><strong>${data.success}</strong></div>`;
        output.classList.remove('d-none');
        
        // Show Image
        uploadedImage.src = data.image_url;
        imagePreview.classList.remove('d-none');
        imageCoverPreview.value = data.image_url;
        document.getElementById('cover-preview').style.backgroundImage = "url('"+data.image_url+"')";
        
        // Reset form
        form.reset();

    } catch (error) {
        // Error Logic
        console.error(error);
        let errorMessage = 'Something went wrong.';
        
        // Check if it's a validation error (Laravel returns 'message' and 'errors' object)
        if (error.errors && error.errors.image) {
            errorMessage = error.errors.image[0];
        } else if (error.message) {
            errorMessage = error.message;
        }

        errorText.innerText = errorMessage;
        errorText.classList.remove('d-none');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Cargar';
    }
});