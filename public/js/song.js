const button = document.getElementById('addBtn');
const input = document.getElementById('songName');
const songList = document.getElementById('songList');

button.addEventListener('click', async () => {
    const songName = input.value.trim();
    if (!songName) return alert('Please enter a song name');

    try {
        const response = await fetch(`${APP_URL}/api/songs`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: songName })
        });

        const data = await response.json();
        if (data.error) return alert(data.error);

        const li = document.createElement('li');
        li.textContent = songName;
        songList.appendChild(li);
        input.value = '';
    } catch (err) {
        console.error('Error:', err);
    }
});