<?php
// Zoom App credential
$config['ZOOM_CLIENT_ID'] = 'M5lp65SyTzCMWHvJmXE_sA';
$config['ZOOM_CLIENT_SECRET'] = 'sQowadEg6gvH2owT2zmYtJ2INmUaAADc';
$config['ZOOM_REDIRECT_URI'] = 'https://c2a2330d8590.ngrok.io/zoom/callback';
$config['ZOOM_AUTHORISED_URL'] = "https://zoom.us/oauth/authorize?client_id=".$config['ZOOM_CLIENT_ID']."&response_type=code&redirect_uri=".$config['ZOOM_REDIRECT_URI'];



