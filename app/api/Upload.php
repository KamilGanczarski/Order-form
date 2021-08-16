<?php

session_start();
mysqli_report(MYSQLI_REPORT_STRICT);
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

class JSON_API_uplaod {
    private function set_order() {
        echo json_encode([]);
    }

    private function return_nothing() {
        echo json_encode([]);
    }

    public function direct_to_request($type) {
        switch ($type) {
            case 'currency':
                $this->set_order();
                break;
            default:
                $this->return_nothing();
        }
    }
}

$JSON_API_uplaod_obj = new JSON_API_uplaod();
// Check allowed server
if (isset($_GET['t']) && in_array($_SERVER['HTTP_HOST'], $App['allowed_hosts']))
    $JSON_API_uplaod_obj->direct_to_request($_GET['t']);
else
    echo json_encode([]);
