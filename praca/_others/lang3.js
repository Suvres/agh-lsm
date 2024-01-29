useRecognition((text) => {
    var tt = text.toLowerCase()
    document.getElementById('result').innerText = text
    if (index) {
        const sss = String(text).trim().slice(0, -1);
        const _class = 'index-' + textToNumber(sss);
        document.getElementById(_class).click()
    }
    if (focus) {
        var sss = String(text).trim().slice(0, -1);
        if (number) {
            element.value = textToNumber(sss);
        } else if (ddate) {
            element.value = Date.parse(String(text).trim());
        } else {
            element.value = sss;
        }
        element.dispatchEvent(new Event('keyup'))
        element = null
        number = false;
        focus = false
        return
    }
    if (book || user) {
        var sss = String(text).toLowerCase().trim().slice(0, -1);
        document.getElementById(sss).click()
    }
    tt = tt.slice(0, -1)
    let utterance = new SpeechSynthesisUtterance('Rozpoznano: ' + tt);
    speechSynthesis.speak(utterance);
})