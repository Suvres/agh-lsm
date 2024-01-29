  speechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
    speechGrammarList = window.SpeechGrammarList || window.webkitSpeechGrammarList
    speechRecognitionEvent = window.SpeechRecognitionEvent || window.webkitSpeechRecognitionEvent
    grammar = '#JSGF V1.0;';
    recognition = new speechRecognition();
    speechRecognitionList = new speechGrammarList();
    speechRecognitionList.addFromString(grammar, 1);
    recognition.grammars = speechRecognitionList;
    recognition.continuous = true;
    recognition.lang = 'pl-PL';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    var recognizing = false;
    var focus = false;
    var number = false
    var element = null;
    var book = false;
    var user = false;
    var ddate = false;
    var index = false;