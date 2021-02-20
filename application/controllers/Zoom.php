<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zoom extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();

//        $this->load->model('admin/zoom_model');
    }


    public function callback()
    {

        require_once __DIR__ . '/../../vendor/autoload.php';

        $baseURL = $this->config->config["base_url"];
        if (isset($_GET['code']) && !empty($_GET['code'])){
            try {
                $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);

                $response = $client->request('POST', '/oauth/token', [
                    "headers"     => [
                        "Authorization" => "Basic " . base64_encode($this->config->item('ZOOM_CLIENT_ID') .
                                ':' . $this->config->item('ZOOM_CLIENT_SECRET'))
                    ],
                    'form_params' => [
                        "grant_type"   => "authorization_code",
                        "code"         => $_GET['code'],
                        "redirect_uri" => $this->config->item('ZOOM_REDIRECT_URI')
                    ],
                ]);

                $token = json_decode($response->getBody()->getContents(), true);

                $refId = 2;
                if (isset($_COOKIE['__ref_id'])) {
                    $refId = $_COOKIE['__ref_id'];
                }

                $data["zoom_access_token"] = json_encode($token);
                $data["zoom_connected_at"] = date('Y-m-d H:i:s');
                $data["zoom_refreshed_at"] = date('Y-m-d H:i:s');

                $this->db->where('id', $refId);
                $this->db->update('users', $data);

            } catch (Exception $e) {
                header("Location: ".$baseURL."/#/my-account?zoom_status=error");
            }

            header("Location: ".$baseURL."/#/my-account?zoom_status=success");
        }

        header("Location: ".$baseURL."/#/my-account?zoom_status=error");
    }
}