<?php

session_start();
mysqli_report(MYSQLI_REPORT_STRICT);
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");
require '../../vendor/Database/PDO-Mysql.php';

class JSON_API_fetch {
    protected $valid = true, $res = [];

    private function set_order() {
        $Order = new stdClass;
        $Order->coupon_codes = DB::select("SELECT * FROM Coupon_code;");
        $Order->countries = DB::select("SELECT * FROM Country;");
        $Order->status = 400;
        echo json_encode($Order);
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
                $this->set_order();
                break;
            default:
                $this->return_nothing();
        }
    }
}

$JSON_API_fetch_obj = new JSON_API_fetch();
// Check allowed server
if (isset($_GET['t']))
    $JSON_API_fetch_obj->direct_to_request($_GET['t']);
else
    echo json_encode([]);
