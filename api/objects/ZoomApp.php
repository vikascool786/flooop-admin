<?php

include_once __DIR__ . '../objects/user.php';
include_once __DIR__ . '../objects/timezone.php';
include_once __DIR__ . '../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;

class ZoomApp
{
    public function __construct()
    {
    }

    /**
     * Create zoom meeting
     *
     * @param $userId
     * @return mixed|null
     */
    public function createMeetingOnZoom($userId, $data)
    {

        $accessToken = $this->getAccessTokenOfUser($userId);

        try {
            $data = $this->scheduleMeetingOnZoom($accessToken->access_token, $data);
        } catch (GuzzleException $e) {
            $data = null;
        }

        if (is_null($data)) {
            try {
                $accessToken = $this->getRefreshTokenOfUser($userId);
            } catch (GuzzleException $e) {
                $accessToken = null;
            }

            if (!is_null($accessToken)) {
                try {
                    $data = $this->scheduleMeetingOnZoom($accessToken->access_token, $data);
                } catch (GuzzleException $e) {
                    $data = null;
                }
            }
        }

        return $data;
    }

    /**
     * Schedule meeting on zoom
     *
     * @param $accessToken
     * @return mixed|null
     * @throws GuzzleException
     */
    private function scheduleMeetingOnZoom($accessToken, $data)
    {

        $randomPassword = mt_rand(100000, 999999);
        if (isset($data->event_duration)) {
            preg_match_all('!\d+!', $data->event_duration, $matches);
            $data->event_duration = $matches[0][0];
        } else {
            $data->event_duration = 30;
        }

        $eventDatetime = $data->event_date . " " .
            date("H:i", strtotime("$data->event_start_hours:$data->event_start_minutes " .
                strtoupper($data->event_start_AmPm)));
        try {
            $eventTimezone = new DateTimeZone($data->event_start_timezone_title);
            $dateObject = new DateTime($eventDatetime, $eventTimezone);
            $eventDatetime = $dateObject->format('Y-m-d\TH:i:s \G\M\TO');
        } catch (Exception $e) {

        }

        try {

            $zoomTimeZone = $this->getTimeZone($data->event_start_timezone);

            $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

            // if you have user id of user than change it with me in url
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $accessToken"
                ],
                'json'    => [
                    "topic"      => $data->event_title,
                    "type"       => 2,
                    "start_time" => $eventDatetime,                 // meeting start time
                    "duration"   => "$data->event_duration",        // minutes
                    "password"   => $randomPassword,                // meeting password
                    "timezone"   => $zoomTimeZone
                ],
            ]);

            return json_decode($response->getBody());

        } catch (Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * update zoom meeting
     *
     * @param $userId
     * @return mixed|null
     */
    public function updateMeetingOnZoom($userId, $data)
    {

        $accessToken = $this->getAccessTokenOfUser($userId);

        try {
            $data = $this->updateMeetingToZoom($accessToken->access_token, $data);
        } catch (GuzzleException $e) {
            $data = null;
        }

        if (is_null($data)) {
            try {
                $accessToken = $this->getRefreshTokenOfUser($userId);
            } catch (GuzzleException $e) {
                $accessToken = null;
            }

            if (!is_null($accessToken)) {
                try {
                    $data = $this->updateMeetingToZoom($accessToken->access_token, $data);
                } catch (GuzzleException $e) {
                    $data = null;
                }
            }
        }

        return $data;
    }

    /**
     * update meeting on zoom
     *
     * @param $accessToken
     * @return mixed|null
     * @throws GuzzleException
     */
    private function updateMeetingToZoom($accessToken, $data)
    {

        if (isset($data->event_duration)) {
            preg_match_all('!\d+!', $data->event_duration, $matches);
            $data->event_duration = $matches[0][0];
        } else {
            $data->event_duration = 30;
        }

        $eventDatetime = $data->event_date . " " .
            date("H:i", strtotime("$data->event_start_hours:$data->event_start_minutes " .
                strtoupper($data->event_start_AmPm)));
        try {
            $eventTimezone = new DateTimeZone($data->event_start_timezone_title);
            $dateObject = new DateTime($eventDatetime, $eventTimezone);
            $eventDatetime = $dateObject->format('Y-m-d\TH:i:s \G\M\TO');
        } catch (Exception $e) {

        }

        if ($data->zoom_id != "") {
            try {
                $zoomTimeZone = $this->getTimeZone($data->event_start_timezone);

                $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

                // if you have user id of user than change it with me in url
                $response = $client->request('PATCH', '/v2/meetings/' . $data->zoom_id, [
                    "headers" => [
                        "Authorization" => "Bearer $accessToken"
                    ],
                    'json'    => [
                        "topic"      => $data->event_title,
                        "type"       => 2,
                        "start_time" => $eventDatetime,                // meeting start time
                        "duration"   => "$data->event_duration",       // minutes
                        "timezone"   => $zoomTimeZone
                    ],
                ]);

                return json_decode($response->getBody());

            } catch (Exception $e) {
                return null;
            }
        }


    }

    /**
     * Get the user's access token
     *
     * @param $userId
     * @return mixed|null
     */
    private function getAccessTokenOfUser($userId)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            $user = new User($db);
            $stmtUser = $user->readSingle(['id' => $userId]);
            $rowUser = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if (!is_null($rowUser)) {
                return json_decode($rowUser['zoom_access_token']);
            }
        } catch (Exception $e) {

        }

        return null;
    }

    /**
     * Get the refresh token
     *
     * @param $userId
     * @return StreamInterface|null
     * @throws GuzzleException
     */
    private function getRefreshTokenOfUser($userId)
    {
        $config = [];
        require __DIR__ . '/../../application/config/zoom.php';

        try {
            $result = $this->getAccessTokenOfUser($userId);

            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers"     => [
                    "Authorization" => "Basic " . base64_encode($config['ZOOM_CLIENT_ID'] . ':' .
                            $config['ZOOM_CLIENT_SECRET'])
                ],
                'form_params' => [
                    "grant_type"    => "refresh_token",
                    "refresh_token" => $result->refresh_token
                ],
            ]);

            $accessToken = $response->getBody();

            // If access token updated successfully into the storage
            if ($this->updateAccessTokenOnZoom($userId, $accessToken)) {
                return json_decode($accessToken);
            }
        } catch (Exception $e) {

            return null;
        }

        return null;
    }

    /**
     * Update the access token into the storage
     *
     * @param $userId
     * @param $accessToken
     * @return bool
     */
    private function updateAccessTokenOnZoom($userId, $accessToken)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            $user = new User($db);
            $user->zoom_access_token = $accessToken;
            $user->zoom_refreshed_at = date('Y-m-d H:i:s');
            $user->id = $userId;

            if ($user->updateAccessToken()) {
                return true;
            }
        } catch (Exception $e) {

            return false;
        }


        return false;
    }

    /**
     * Get the time zone value by ID
     *
     * @param $timeZoneId
     * @return bool
     */
    private function getTimeZone($timeZoneId)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            $timeZone = new User($db);
            $stmtTimeZone = $timeZone->readTimeZone(['id' => $timeZoneId]);
            $rowTimeZone = $stmtTimeZone->fetch(PDO::FETCH_ASSOC);

            if (!is_null($rowTimeZone)) {
                return $rowTimeZone['value'];
            }

        } catch (Exception $e) {

            return false;
        }
        
        return false;
    }

}