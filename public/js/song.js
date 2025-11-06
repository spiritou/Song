const button = document.getElementById('addBtn');
const input = document.getElementById('songName');
const songList = document.getElementById('songList');
let lastUpdate = null;

button.addEventListener('click', async () => {
    const songName = input.value.trim();
    if (!songName) return alert('Please enter a song name');

    try {
        const response = await fetch('api/songs', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: songName })
        });

        if (!response.ok) throw new Error('Failed to save the song');

        const data = await response.json();
        if (data.error) return alert(data.error);

        const newSong = data.song;
        const li = createSongElement(newSong);
        songList.appendChild(li);
        
        input.value = '';
    } catch (err) {
        console.error('Error:', err);
    }
});

// Fetch and display existing songs on page load

async function fetchSongs() {
 

    let url = !lastUpdate
        ? 'api/songs'
        : `api/songs/changes?since=${encodeURIComponent(lastUpdate)}`;

        console.log(`Fetching from URL: ${url}`);

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (data.changes && data.changes.length === 0) return; // No changes, skip updating the list

            const songs = data.songs || data.changes;

            songs.forEach(song => {
                let li = document.querySelector(`li[data-id='${song.id}']`);
                if (li) {
                    // li.textContent = song.name; // Update existing song
                    const updatedLi = createSongElement(song);
                    li.replaceWith(updatedLi);
                } else {
                    li = createSongElement(song);
                    songList.appendChild(li); // Add new song
                }
            });

            lastUpdate = data.last_update;
        } catch (err) {
            console.error('Error fetching songs:', err);
        }

      
}

function createSongElement(song) {
    const li = document.createElement('li');
    li.dataset.id = song.id;
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
            const response = await fetch(`api/songs/${song.id}`, {
                method: 'DELETE'
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

            const response = await fetch(`api/songs/${song.id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: newName })
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
    stopPolling();
    pollingInterval = setInterval(fetchSongs, 5000); // 5 seconds
}

function stopPolling() {
    clearInterval(pollingInterval);
}

fetchSongs();
startPolling();


