<?php

function get_users() {
  global $connect;
  $query = "SELECT id, firstname, lastname, created_at, updated_at FROM users";
  global $connect;
  $res = pg_query($connect, $query);
 
  $users = array();
  while($r = pg_fetch_object($res))
    $users[] = $r;

  return $users;
}

function get_user_by_login($login) {
  global $connect;
  $login = pg_escape_string($login);
  $query = "SELECT * FROM users WHERE login = '$login'";
  $res = pg_query($query);
  if(!$res) return false;
  
  $user = pg_fetch_object($res);
  return empty($user) ? false : $user;
}

function get_user_by_id($id){
	global $connect;
	$query = "SELECT id, firstname, lastname, created_at, updated_at, login FROM users where id=$id;";
  $res = pg_query($query); 
  $user = pg_fetch_object($res);
  return $user;
}

?>