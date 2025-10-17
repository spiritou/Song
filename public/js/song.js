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

        // const li = document.createElement('li');
        // li.textContent = songName;
        const newSong = {name: songName};
        const li = createSongElement(newSong);
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

        songList.innerHTML = ''; // Clear existing list
        songs.forEach(song => {
            // const li = document.createElement('li');
            // li.textContent = song.name;
            const li = createSongElement(song);
            songList.appendChild(li);
            console.log(song);
        });
    } catch (err) {
        console.error('Error fetching songs:', err);
    }
}

function createSongElement(song) {
    const li = document.createElement('li');
    li.textContent = song.name;

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.style.marginLeft = '10px';
    li.appendChild(deleteBtn);

    const updateBtn = document.createElement('button');
    updateBtn.textContent = 'Update';
    updateBtn.style.marginLeft = '10px';
    li.appendChild(updateBtn);

    deleteBtn.addEventListener('click', async () => {
        console.log(`URL being fetched: api/songs/${song.id}`);
        try {
            const response = await fetch('api/songs', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: song.id })
            });

            const data = await response.json();

            if(data.success) {
                li.remove();
            } else {
                alert(data.error || 'Failed to delete the song');
            }
        } catch (err) {
            console.error('Error deleting song:', err);
        }
    });

    updateBtn.addEventListener('click', () => {

        stopPolling();
        const input = document.createElement('input');
        input.type = 'text';
        input.value = song.name;
       
        const saveBtn = document.createElement('button');
        saveBtn.textContent = 'Save';
        saveBtn.style.marginLeft = '10px';
        const cancelBtn = document.createElement('button');
        cancelBtn.textContent = 'Cancel';
        cancelBtn.style.marginLeft = '10px';

        li.innerHTML = '';
        li.appendChild(input);
        li.appendChild(saveBtn);
        li.appendChild(cancelBtn);

        saveBtn.addEventListener('click', async () => {
            startPolling();
            const newName = input.value.trim();
            if (!newName) return alert('Please enter a song name');

            const response = await fetch('api/songs', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: song.id, name: newName })
            });

            const data = await response.json();
            if (data.success) {
                song.name = newName;
                const updatedLi = createSongElement(song);
                li.replaceWith(updatedLi);
            } else {
                alert(data.error || 'Failed to update the song');
            }
        });

        cancelBtn.addEventListener('click', () => {
            const originalLi = createSongElement(song);
            li.replaceWith(originalLi);
        });
    });
    return li;
}

let pollingInterval;

function startPolling() {
    pollingInterval = setInterval(fetchSongs, 5000); // 5 seconds
}

function stopPolling() {
    clearInterval(pollingInterval);
}

fetchSongs();
