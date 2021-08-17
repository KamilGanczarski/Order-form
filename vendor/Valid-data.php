<?php

class Valid_data {
    protected function check_name($text) {
        if ($this->valid && strlen($text) < 2 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Niepoprawne imię (imię powinno mieć od 2 od 255 znaków)", "danger");
        }
    }

    protected function check_surname($text) {
        if ($this->valid && strlen($text) < 2 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Niepoprawne nazwisko (nazwisko powinno mieć od 2 od 255 znaków)", "danger");
        }
    }

    protected function check_login($text) {
        $sql = "SELECT * FROM User WHERE login = '$text';";
        if ($this->valid && strlen($text) < 6 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Niepoprawny login (login powinien mieć od 6 od 255 znaków)", "danger");
        } else if ($this->valid && count(DB::select($sql)) > 0) {
            $this->valid = false;
            $this->add_response("Taki login już istnieje", "danger");
        }
    }

    protected function check_password($password, $repeat_password) {
        if ($this->valid && strlen($password) < 6 || strlen($password) > 255) {
            $this->valid = false;
            $this->add_response("Niepoprawne hasło (hasło powinno mieć od 2 od 255 znaków)", "danger");
        } else if ($this->valid && !preg_match("#[0-9]+#", $password)) {
            $this->valid = false;
            $this->add_response("Hasło powinno zawierać chociaż jedną cyfrę", "danger");
        } else if ($this->valid && !preg_match("#[A-Z]+#", $password)) {
            $this->valid = false;
            $this->add_response("Hasło powinno zawierać chociaż jedną wielką literę", "danger");
        } else if ($this->valid && !preg_match("#[a-z]+#", $password)) {
            $this->valid = false;
            $this->add_response("Hasło powinno zawierać chociaż jedną małą literę", "danger");
        } else if ($this->valid && $password != $repeat_password) {
            $this->valid = false;
            $this->add_response("Hasła powinny być identyczne", "danger");
        }
    }

    protected function check_country($text) {
        if ($this->valid && strlen($text) < 4 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Nieprawidłowe państwo (państwo powinno mieć od 4 od 255 znaków)", "danger");
        }
    }

    protected function check_address($text) {
        if ($this->valid && strlen($text) < 6 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Nieprawidłowy adres (adres powinien mieć od 6 od 255 znaków)", "danger");
        }
    }

    protected function check_postcode($text) {
        if ($this->valid && strlen($text) < 2 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Nieprawidłowy kod pocztowy (kod pocztowy powinien mieć od 2 od 255 znaków)", "danger");
        }
    }

    protected function check_town($text) {
        if ($this->valid && strlen($text) < 6 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Nieprawidłowe miasto (miasto powinno mieć od 6 od 255 znaków)", "danger");
        }
    }

    protected function check_phone($text) {
        if ($this->valid && strlen($text) < 9 || strlen($text) > 255) {
            $this->valid = false;
            $this->add_response("Nieprawidłowy numer telefonu (numer telefonu powinien mieć od 9 od 255 znaków)", "danger");
        }
    }

    protected function check_delivery_method($text) {
        if ($this->valid && !in_array($text, ['Paczkomaty 24/7', 'Kurier DPD', 'Kurier DPD pobranie'])) {
            $this->valid = false;
            $this->add_response("Nieprawidłowy sposób dostawy", "danger");
        } else if ($this->valid) {
            $Deliveries = DB::select(
                "SELECT * FROM Delivery_method WHERE description = '$text';"
            );
            if (count($Deliveries) > 0) {
                $this->delivery_price = $Deliveries[0]['price'];
            }
        }
    }

    protected function check_payment_method($text) {
        if ($this->valid && !in_array($text, ['PayU', 'Płatność przy odbiorze', 'Przelew bankowy - zwykły'])) {
            $this->valid = false;
            $this->add_response("Nieprawidłowy sposób płatności", "danger");
        }
    }

    protected function check_coupon_code($code) {
        $sql = "SELECT * FROM Coupon_code WHERE active = '1' AND code = '$code'";
        $Codes = DB::select($sql);
        if ($this->valid && count($Codes) > 0)
            $this->coupon_code = $Codes[0]['percent'];
    }
}
