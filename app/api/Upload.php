<?php

session_start();
mysqli_report(MYSQLI_REPORT_STRICT);
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
require '../../vendor/Database/PDO-Mysql.php';
require '../../vendor/Valid-data.php';

class JSON_API_upload extends Valid_data {
    protected
        $valid = true,
        $res = [],
        $price = 115,
        $coupon_code = 0,
        $delivery_price = 0;

    private function create_account($Order) {
        // Quote string with slashes
        $Order->login = addslashes($Order->login);
        $Order->name = addslashes($Order->name);
        $Order->surname = addslashes($Order->surname);

        // Hash password
        if ($Order->password != '')
            $Order->password = password_hash($Order->password, PASSWORD_DEFAULT);
        
        // Prepare query
        $sql = "INSERT INTO User (login, pass, name, surname) VALUES
            ('$Order->login', '$Order->password', '$Order->name', '$Order->surname');";
     
        if ($this->valid && DB::insert($sql) > 0) {
            // Take id from new user
            $user_id = DB::select("SELECT * FROM User ORDER BY id DESC LIMIT 1;")[0]['id'];
        } else if ($this->valid) {
            $this->valid = false;
            $this->add_response("Nowy użytkownik nie został dodany", "danger");
        }

        return ($this->valid) ? $user_id : 0;
    }

    private function add_new_address($Order, $user_id) {
        // Quote string with slashes
        $Order->country = addslashes($Order->country);
        $Order->address = addslashes($Order->address);
        $Order->postcode = addslashes($Order->postcode);
        $Order->town = addslashes($Order->town);
        $Order->phone = addslashes($Order->phone);

        $Order->delivery_country = addslashes($Order->delivery_country);
        $Order->delivery_address = addslashes($Order->delivery_address);
        $Order->delivery_postcode = addslashes($Order->delivery_postcode);
        $Order->delivery_town = addslashes($Order->delivery_town);

        $Order->delivery_method = addslashes($Order->delivery_method);
        $Order->payment_method = addslashes($Order->payment_method);
        
        // Prepare query
        // If another delivery place is set
        if ($Order->another_delivery_place) {
            $sql = "INSERT INTO Address
                (user_id, Country, address, postcode, town, phone) VALUES
                ('$user_id', '$Order->delivery_country', '$Order->delivery_address', '$Order->delivery_postcode', '$Order->delivery_town', '$Order->phone');";
        } else {
            $sql = "INSERT INTO Address
                (user_id, Country, address, postcode, town, phone) VALUES
                ('$user_id', '$Order->country', '$Order->address', '$Order->postcode', '$Order->town', '$Order->phone');";
        }

        if ($this->valid && DB::insert($sql) == 0) {
            $this->valid = false;
            $this->add_response("Address nie został dodany", "danger");
        }
    }

    private function add_new_order($Order, $user_id) {
        $order_number = uniqid('gfg', true);
        $Order->delivery_method = addslashes($Order->delivery_method);
        $Order->payment_method = addslashes($Order->payment_method);

        // Prepare query
        $sql = "INSERT INTO Order_info
            (user_id, order_number, price, delivery_method, payment_method, comment) VALUES
            ('$user_id', '$order_number', '$this->price', '$Order->delivery_method', '$Order->payment_method', '$Order->comment');";

        if ($this->valid && DB::insert($sql) == 0) {
            $this->valid = false;
            $this->add_response("Zamówienie nie zostało dodane", "danger");
        }
    }

    private function valid_order($Order) {
        $user_id = 0;
        $this->check_name($Order->name); // Check name
        $this->check_surname($Order->surname); // Check surname

        // If create client account
        if ($Order->create_new_account) {
            // Check login
            $this->check_login($Order->login);

            // Check password
            $this->check_password($Order->password, $Order->repeat_password);
        // Later change to into permission client/guest
        } else {
            $Order->login = 'guest';
            $Order->password = '';
        }

        $this->check_country($Order->country); // Check country
        $this->check_address($Order->address); // Check adress
        $this->check_postcode($Order->postcode); // Check postcode
        $this->check_town($Order->town); // Check town
        $this->check_phone($Order->phone); // Check phone

        // If another delivery place is set
        if ($Order->another_delivery_place) {
            $this->check_country($Order->delivery_country); // Check delivery country
            $this->check_address($Order->delivery_address); // Check delivery adress
            $this->check_postcode($Order->delivery_postcode); // Check delivery postcode
            $this->check_town($Order->delivery_town); // Check delivery town
        }

        $this->check_delivery_method($Order->delivery_method);
        $this->check_payment_method($Order->payment_method);

        $this->check_coupon_code($Order->actives_coupons);
    }

    private function delete_all_changes($user_id) {
        DB::delete("DELETE FROM User WHERE id = '$user_id';");
        DB::delete("DELETE FROM Order_info WHERE user_id = '$user_id';");
        DB::delete("DELETE FROM Order_info WHERE user_id = '$user_id';");
    }

    private function set_order($Order) {
        $Order = json_decode($Order);
        // Check all data
        $this->valid_order($Order);
        // Add new user
        $user_id = $this->create_account($Order);
        // Add new address
        $this->add_new_address($Order, $user_id);

        // Calc final price
        
        // Add coupon code to price
        $this->price -= $this->price * $this->coupon_code;

        // Add delivery price to final price
        $this->price += $this->delivery_price;

        // Add new order
        $this->add_new_order($Order, $user_id);

        if (!$this->valid || $user_id == 0)
            $this->delete_all_changes($user_id);
        else
            $this->add_response("Zamówienie zostało złożone", "success");

        echo json_encode($this->res);
    }

    /**
     * Add translated text to array of objects $this->res with priority
     * @param string $str Any text
     * @param string $priority priority Bootstrap class colors
     *      like: success, danger
     */
    public function add_response($str, $priority) {
        array_push($this->res, [
            "message" => $str,
            "style" => $priority
        ]);
    }

    private function return_nothing() {
        $this->res = [];
        echo json_encode($this->res);
    }

    public function direct_to_request($type) {
        switch ($type) {
            case 'set-order':
                if (isset($_GET['Order']))
                    $this->set_order($_GET['Order']);
                else
                    $this->return_nothing();
                break;
            default:
                $this->return_nothing();
        }
    }
}

$JSON_API_upload_obj = new JSON_API_upload();
// Check allowed server
if (isset($_GET['t']) && in_array($_SERVER['HTTP_HOST'], $App['allowed_hosts']))
    $JSON_API_upload_obj->direct_to_request($_GET['t']);
else
    echo json_encode([]);
