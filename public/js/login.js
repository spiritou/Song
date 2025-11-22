// the javascript code for login page

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const username = document.getElementById('name').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!username || !password) {
        return alert('Please enter both username and password');
    }

        const response = await fetch('api/login', {
            method: 'POST',
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ username, password})
        });

        const data = await response.json();
        if (data.success) {
            window.location.href = 'homepage'; // redirect to dashboard or home page
        } else {
            alert(data.error || 'Login failed');
        }

    });