switch(String(tt).trim()) {
        case 'login':
            document.getElementById('inputEmail').focus()
            focus = true;
            break;
        case 'haslo':
            document.getElementById('inputPassword').focus()
            focus = true;
            break;
        case 'zaloguj sie':
            document.getElementById('submit').click()
            break;
        case 'ja':
            document.getElementById('Ja').click()
            break;
        case 'wyloguj sie':
            document.getElementById('Wyloguj sie').click()
            break;
        case 'uzytkownicy':
            document.getElementById('Uzytkownicy').click()
            break;
        case 'zarzadzaj':
            document.getElementById('Zarzadzaj').click()
            break;
        case 'ksiazki':
            document.getElementById('Ksiazki').click()
            break;
        case 'panel':
            document.getElementById('Panel').click()
            break;

        case 'dodaj':
        case 'dodaj nową':
        case 'dodaj nową ksiazkę':
        case 'dodaj nowego':
            document.getElementById('dodaj').click()
            break;

        case 'tytul':
            document.getElementById('book_form_title').focus()
            element = document.getElementById('book_form_title')
            focus = true
            break;

        case 'autor':
            document.getElementById('book_form_author').focus()
            element = document.getElementById('book_form_author')
            focus = true
            break;
        case 'wiek':
            document.getElementById('book_form_ageThreshold').focus()
            element = document.getElementById('book_form_ageThreshold')
            focus = true
            number = true
            break;
        case 'granica wieku':
            document.getElementById('book_form_ageThreshold').focus()
            element = document.getElementById('book_form_ageThreshold')
            focus = true
            number = true
            break;

        case 'zapisz':
            document.getElementById('zapisz').click()
            break;
        case 'powrot':
            document.getElementById('powrot').click()
            break;

        case 'ksiazka':
            document.getElementById('książka').style.backgroundColor = 'red'
            book = true
            break;
        case 'usun':
            document.getElementById('book-del').click()
            break;
        case 'dodaj kopie':
            document.getElementById('book-new-copy').click();
            break;
        case 'edytuj ksiazke':
            document.getElementById('book-edit').click();
            break;
        case 'wypozycz':
            document.getElementById('new-loan').click();
            document.getElementById('new-loan').style.backgroundColor = 'red';
            break;
        case 'uzytkownik':
            document.getElementById('user').style.backgroundColor = 'red'
            user = true
            break;
        case 'oddaj':
            document.getElementById('loan-return').click();
            break;
        case 'imie':
            document.getElementById('user_form_name').focus();
            element = document.getElementById('user_form_name');
            focus = true;
            break;
        case 'nazwisko':
            element = document.getElementById('user_form_surname');
            document.getElementById('user_form_surname').focus();
            focus = true;
            break;
        case 'email':
            element = document.getElementById('user_form_email');
            document.getElementById('user_form_email').focus();
            focus = true;
            break;
        case 'data':
            element = document.getElementById('user_form_birthDate');
            document.getElementById('user_form_birthDate').focus();
            focus = true;
            ddate = true;
            break;
        case 'wyszukaj':
            element = document.querySelector('#booksCopies_filter label input');
            element.focus();
            focus = true;
            break;
        case 'indeks':
        case 'index':
            element = document.querySelectorAll('.index');
            element.forEach(n => {
                n.style.backgroundColor = 'red'
            })
            index = true
            break;
    }