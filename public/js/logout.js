document.getElementById('LogoutBtn').addEventListener('click', async () => {
    try {
        const response = await fetch('api/logout', {
            method: 'POST',
            headers: {"Content-Type": "application/json"}
        });

        const data = await response.json();

        if (data.success) {
            console.log('Logout successful');
            window.location.href = '/'; // redirect to login page
        } else {
            alert(data.error || 'Logout failed');
        }
    } catch (err) {
        console.error('Error during logout:', err);
    }
});