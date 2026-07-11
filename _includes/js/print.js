/**
 * Automatically triggers the print dialog if 'print=true' is in the URL.
 * Also cleans up the URL after the print dialog is closed.
 */
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('print') === 'true') {
        // Trigger the system print dialog
        window.print();
        
        // Clean up the URL by removing the print parameter 
        // without refreshing the page
        const newUrl = window.location.pathname + '?' + 
                     urlParams.toString().replace(/&?print=true/, '').replace(/\?$/, '');
                     
        window.history.replaceState(null, '', newUrl);
    }
});