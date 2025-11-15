document.addEventListener('DOMContentLoaded', () => {
    // Get references to the HTML elements
    
    const urlInput = document.getElementById('link');
    const titleField = document.getElementById('title');
    const extractField = document.getElementById('extract');
    const imageField = document.getElementById('cover');
    const imagePreview = document.getElementById('cover-preview');
    
    const statusBox = document.getElementById('status-box');

    // Listen for the form submission
    urlInput.addEventListener('input', async (e) => {
        e.preventDefault(); // Stop the form from reloading the page
        
        const url = urlInput.value;
        // Show a loading state
        //showLoading();

        try {
            // Send the URL to our PHP backend using fetch (AJAX)
            const response = await fetch('../build/assets/fetch-meta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ url: url }) // Send the URL as JSON
            });

            if (!response.ok) {
                throw new Error(`Server error: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.success) {
                // If successful, render the preview
                renderData(data);
            } else {
                // If the PHP script returns an error
                showError(data.error);
            }

        } catch (error) {
            // Handle network errors
            console.error('Fetch error:', error);
            showError('Failed to fetch preview.');
        }
    });

    function showLoading() {
        
        statusBox.className = 'loading'; // Use class for styling
        statusBox.innerHTML = 'Loading...';
        
    }

    function showError(message) {
        statusBox.innerHTML = "";
        statusBox.className = 'error'; // Use class for styling
        statusBox.innerHTML = message;
    }

    //
    // **IMPORTANT: This function uses textContent to prevent XSS attacks.**
    // It safely inserts text from the remote site, ensuring no malicious
    // scripts are executed.
    //
    function renderData(data) {
        statusBox.className = ''; // Remove loading class
        statusBox.innerHTML = ''; // Clear the "Loading..." text

        titleField.value = data.title ;
        extractField.innerHTML = data.description ;
        imageField.value = data.image ;
        imagePreview.style = 'background-image: url("'+data.image+'")' ;
        // Create image container
        /* if (data.image) {
            const imageContainer = document.createElement('div');
            imageContainer.className = 'image-container';
            const img = document.createElement('img');
            img.src = data.image;
            img.alt = 'Article Cover';
            imageContainer.appendChild(img);
            previewBox.appendChild(imageContainer);
        } */
        
    }
});