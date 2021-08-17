class Valid_data {
    // Check name
    static check_name(text) {
        if (text.length < 2 || text.length > 255) {
            return {
                message: 'Niepoprawne imię (imię powinno mieć od 2 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check surname
    static check_surname(text) {
        if (text.length < 2 || text.length > 255) {
            return {
                message: 'Niepoprawne nazwisko (nazwisko powinno mieć od 2 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check login
    static check_login(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Niepoprawny login (login powinien mieć od 6 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check password
    static check_password(password, password_repeat) {
        if (password.length < 6 || password.length > 255) {
            return {
                message: 'Niepoprawne hasło (hasło powinno mieć od 2 od 255 znaków)',
                style: 'danger'
            };
        } else if (!/([0-9].*[a-z])|([a-z].*[0-9])/.test(password)) {
            return {
                message: 'Hasło powinno zawierać chociaż jedną cyfrę, jedną wielką literę i jedną małą literę',
                style: 'danger'
            };
        } else if (password != password_repeat) {
            return {
                message: 'Hasła powinny być identyczne',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check country
    static check_country(text) {
        if (text.length < 4 || text.length > 255) {
            return {
                message: 'Nieprawidłowe państwo (państwo powinno mieć od 4 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check address
    static check_address(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Nieprawidłowy adres (adres powinien mieć od 6 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check postcode
    static check_postcode(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Nieprawidłowy kod pocztowy (kod pocztowy powinien mieć od 2 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check town
    static check_town(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Nieprawidłowe miasto (miasto powinno mieć od 6 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check phone
    static check_phone(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Nieprawidłowy numer telefonu (numer telefonu powinien mieć od 9 od 255 znaków)',
                style: 'danger'
            };
        } else if (isNaN(text.replace(/\s/g, ''))) {
            return {
                message: 'Nieprawidłowy numer telefonu (numer telefonu powinien zawierać tylko cyfry)',
                style: 'danger'
            };
        }
        else {
            return { message: '', style: 'success' }
        }
    }

    // Check phone
    static check_phone(text) {
        if (text.length < 6 || text.length > 255) {
            return {
                message: 'Nieprawidłowy numer telefonu (numer telefonu powinien mieć od 9 od 255 znaków)',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check delivery method
    static check_delivery_method(text) {
        if (!['Paczkomaty 24/7', 'Kurier DPD', 'Kurier DPD pobranie'].includes(text)) {
            return {
                message: 'Nieprawidłowy sposób dostawy',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    // Check payment method
    static check_payment_method(text) {
        if (!['PayU', 'Płatność przy odbiorze', 'Przelew bankowy - zwykły'].includes(text)) {
            return {
                message: 'Nieprawidłowy sposób płatności',
                style: 'danger'
            };
        } else {
            return { message: '', style: 'success' }
        }
    }

    
}