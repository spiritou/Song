const button = document.getElementById('addBtn');
const input = document.getElementById('songName');
const songList = document.getElementById('songList');

button.addEventListener('click', async () => {
    const songName = input.value.trim();
    if (!songName) return alert('Please enter a song name');

    try {
        const response = await fetch('api/songs', {
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

// Fetch and display existing songs on page load

async function fetchSongs() {
    try {
        const response = await fetch('api/songs');
        if (!response.ok) throw new Error('Network response was not ok');
        const songs = await response.json();
        const songList = document.getElementById('songList');

        list.innerHTML = ''; // Clear existing list
        songs.forEach(song => {
            const li = document.createElement('li');
            li.textContent = song.name;
            songList.appendChild(li);
        });
    } catch (err) {
        console.error('Error fetching songs:', err);
    }
}

fetchSongs();

setInterval(fetchSongs, 30000); // Refresh every 30 seconds