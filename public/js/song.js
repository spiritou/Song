const button = document.getElementById('addBtn');
const input = document.getElementById('songName');
const songList = document.getElementById('songList');

button.addEventListener('click', () => {
    const songName = input.value.trim();
    if(!songName) {
        alert('Please enter a song name');
        return;
    }

    // fetch('/api/songs', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify({ name: songName })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     if(data.error) {
    //         alert(data.error);
    //     } else {
    //         const li = document.createElement('li');
    //         li.textContent = songName;
    //         songList.appendChild(li);
    //         input.value = '';
    //     }
    // })
    // .catch(error => console.error('Error:', error));
});