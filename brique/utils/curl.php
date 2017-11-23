<?php
function curl_post($url, $data_json) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  $result = curl_exec($ch);
  if ( curl_errno($ch) ) {
    throw new Exception(curl_error($ch));
  } else {
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  }
  curl_close($ch);
  return $httpcode === 200 ? true : false;
}
?>
