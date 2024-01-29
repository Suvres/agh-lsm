recognitionEvent = () => {
    document.getElementById('mic').onclick = () => {
        if(!recognizing) {
            document.getElementById('mic').style.backgroundColor = 'red'
            recognizing = true
            recognition.abort();
            recognition.start();
        }
    };
    recognition.addEventListener('nomatch', () => {
        document.getElementById('result').innerText = 'Nie rozpoznano mowy, rozpocznij na nowo';
        document.getElementById('mic').style.backgroundColor = '#343a40'
    });
    recognition.addEventListener('speechend', () => {
        document.getElementById('result').innerText = 'Wykryto koniec mowy, rozpocznij na nowo';
        document.getElementById('mic').style.backgroundColor = '#343a40'
        recognizing = false;
    });
    recognition.addEventListener('error', (event) => {
        document.getElementById('result').innerText = `Wykryto blad: ${event.error}, rozpocznij na nowo`;
        document.getElementById('mic').style.backgroundColor = '#343a40'
        recognizing = false;
    });
    recognition.onstart = function () {
        recognizing = true;
    };
}
