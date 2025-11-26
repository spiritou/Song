document.getElementById('LogoutBtn').addEventListener('click', async () => {
    try {
        const response = await fetch('api/logout', {
            method: 'POST',
            headers: {"Content-Type": "application/json"}
        });

        const data = await response.json();

        if (data.success) {
            console.log('Logout successful');
            // Redirect to login page using APP_URL if available, otherwise use relative path
            const redirectUrl = typeof APP_URL !== 'undefined' ? APP_URL : '/Song/public/';
            window.location.href = redirectUrl;
        } else {
            alert(data.error || 'Logout failed');
        }
    } catch (err) {
        console.error('Error during logout:', err);
    }
});