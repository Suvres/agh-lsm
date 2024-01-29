    textToNumber = (text) => {
        switch (text) {
            case 'jeden':
            case ' jeden':
                return 1;
            case 'dwa':
            case ' dwa':
                return 2;
            case 'trzy':
            case ' trzy':
                return 3;
            case 'cztery':
            case ' cztery':
                return 4;
            case 'piec':
            case ' piec':
                return 5;
            case 'szesc':
            case ' szesc':
                return 6;
            case 'siedem':
            case ' siedem':
                return 7;
            case 'osiem':
            case ' osiem':
                return 8;
            case 'dziewiec':
            case ' dziewiec':
                return 9;
            case 'dziesiec':
            case ' dziesiec':
                return 10;
            case 'jedenascie':
            case ' jedenascie':
                return 11;
            case 'dwanascie':
            case ' dwanascie':
                return 12;
            case 'trzynascie':
            case ' trzynascie':
                return 13;
            case 'czternascie':
            case ' czternascie':
                return 14;
            case 'piętnascie':
            case ' piętnascie':
                return 15;
            case 'szesnascie':
            case ' szesnascie':
                return 16;
            case 'siedemnascie':
            case ' siedemnascie':
                return 17;
            case 'osiemnascie':
            case ' osiemnascie':
                return 18;
            default:
                return parseInt(text)
        }
    }