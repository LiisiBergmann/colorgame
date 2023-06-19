const red = Math.floor(Math.random() * 256);
const green = Math.floor(Math.random() * 256);
const blue = Math.floor(Math.random() * 256);

const colorbox = document.querySelector('#color');
colorbox.style.backgroundColor = `rgb(${red},${green},${blue})`;

const guessbutton = document.querySelector('#guess');

guessbutton.addEventListener('click', async function() {
    const diffred = Math.abs(document.querySelector('#red').value - red);
    const diffgreen = Math.abs(document.querySelector('#green').value - green);
    const diffblue = Math.abs(document.querySelector('#blue').value - blue);
    
    fetch('http://localhost', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            red: diffred,
            green: diffgreen,
            blue: diffblue,
            deviation: diffred + diffgreen + diffblue
        })
    })
    .then (response => response.json())
    .then (data => {
        if (data.error) {
            console.log(data.error);
        } else {
            alert(`Your position in leaderboards: ${data.position}! Click OK to try again.`);
            location.reload();
        }
    })
    .catch(e => console.log(e));
});