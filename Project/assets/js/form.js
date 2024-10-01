function validateForm(event) {
    event.preventDefault(); 

    
    const form = document.getElementById('form');
    const facility = document.getElementById('facility');
    const start = document.getElementById('start');
    const end = document.getElementById('end');
    const purpose = document.getElementById('purpose');
    const email = document.getElementById('email');
    const persons = document.getElementById('persons');
    const consent = document.getElementById('consent');
    const errorMessageDiv = document.getElementById('error-message');


    errorMessageDiv.innerHTML = '';

    let text;

    
    
    if (start.value === '') {
        text = 'Začátek rezervace musí být vyplněn.';
        errorMessageDiv.innerHTML = text;
        return false;
    }
    if (end.value === '') {
        text = 'Konec rezervace musí být vyplněn.';
        errorMessageDiv.innerHTML = text;
        return false;
    }
    if (purpose.value.trim() === '') {
        text = 'Účel rezervace musí být vyplněn.';
        errorMessageDiv.innerHTML = text;
        return false;
    }

    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email.value) || email.value.length <= 6) {
        text = 'Zadejte platný email.';
        errorMessageDiv.innerHTML = text;
        return false;
    }
    if (isNaN(persons.value) || persons.value < 1) {
        text = 'Počet osob musí být alespoň 1.';
        errorMessageDiv.innerHTML = text;
        return false;
    }
    if (!consent.checked) {
        text = 'Musíte souhlasit se zpracováním osobních údajů.';
        errorMessageDiv.innerHTML = text;
        return false;
    }

    alert('Formulář byl úspěšně odeslán!');
    form.submit();
    return true;
}


