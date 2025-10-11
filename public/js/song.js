const button = document.getElementById('addBtn');
const input = document.getElementById('songName');

button.addEventListener('click', () => {
    const songName = input.value;
    console.log(`Adding song: ${songName}`);
    input.value = '';
});