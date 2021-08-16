<?php

session_start();
mysqli_report(MYSQLI_REPORT_STRICT);
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
require '../../vendor/Database/PDO-Mysql.php';

class JSON_API_fetch {
    private function set_order() {
        $Order = new stdClass;
        $Order->coupon_codes = DB::select("SELECT * FROM Coupon_code;");
        $Order->countries = DB::select("SELECT * FROM Country;");
        $Order->status = 400;
        echo json_encode($Order);
    }

    private function return_nothing() {
        echo json_encode([]);
    }

    public function direct_to_request($type) {
        switch ($type) {
            case 'set-order':
                $this->set_order();
                break;
            default:
                $this->return_nothing();
        }
    }
}

$JSON_API_fetch_obj = new JSON_API_fetch();
// Check allowed server
if (isset($_GET['t']) && in_array($_SERVER['HTTP_HOST'], $App['allowed_hosts']))
    $JSON_API_fetch_obj->direct_to_request($_GET['t']);
else
    echo json_encode([]);
