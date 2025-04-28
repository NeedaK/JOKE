document.addEventListener('DOMContentLoaded', function() {

    // Simple confirmation for delete buttons
    const deleteButtons = document.querySelectorAll('a.delete, button.delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault(); // Stop the link/form submission
            }
        });
    });

    // Add more JS for things like:
    // - Client-side form validation (doesn't replace server-side!)
    // - AJAX calls for smoother interactions (e.g., upvoting jokes)
    // - Dynamic UI updates

});