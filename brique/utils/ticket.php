<?php
include_once 'config/client.php';

function cryptTicket($ref) {
  global $pass_ticket;
  return md5( date('Ymd').$ref.$pass_ticket );
}

function isValidTicket($hash, $ref) {
  return $hash === cryptTicket($ref) ? true : false;
}
?>
