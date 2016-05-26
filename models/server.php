<?php

function get_servers() {
  global $connect;
  $query = "SELECT id, name FROM servers";
  $res = pg_query($connect, $query);

  $servers = array();
  while ($r = pg_fetch_object($res))
    $servers[] = $r;

  return $servers;
}

function get_server_by_id($id) {
  global $connect;
  $id = pg_escape_string(strval($id));
  $query = "SELECT id, name, created_at, updated_at FROM servers WHERE id = $id";
  $res = pg_query($query);
  $server = pg_fetch_object($res);

  return $server;
}

function create_server($attributes) {
  $date = date_to_timestamp(time());
  $name = pg_escape_string($attributes['name']);

  global $connect;

  $query = "SELECT name FROM servers";
  $res = pg_query($query);
  $servers_name = array();
  while ($r = pg_fetch_object($res))
    $servers_name[] = $r;

  $rep = "true";
  foreach ($servers_name as $server_name) :

    if ($server_name -> name == $name) {
      $rep = "false";
    }
  endforeach;

  if ($rep == "true") {

    $query = "insert into servers (name, created_at, updated_at) values ('$name', '$date' , '$date')";
    $res = pg_query($query);
    pg_fetch_object($res);

    $id = get_server_last_id();
    $server = get_server_by_id($id);
    return $server;
  } else {
    return $rep;
  }
}

function get_server_last_id() {
  $query = "SELECT currval('servers_id_seq')";
  $res = pg_query($query);
  $r = pg_fetch_array($res);

  return $r[0];
}

function update_server_by_id($id, $attributes) {
  $name = pg_escape_string($attributes['name']);
  $update = date_to_timestamp(time());
  global $connect;
  $query = "UPDATE servers SET name='$name', updated_at='$update' WHERE id=$id";
  $res = pg_query($query);
  pg_fetch_object($res);
  $server = get_server_by_id($id);

  return $server;

}

function get_server_controls() {
  global $connect;
  $query = "SELECT server_id FROM controls order by id ASC";
  $res = pg_query($query);
  $server_controls = array();
  while ($r = pg_fetch_object($res))
    $server_controls[] = $r;

  return $server_controls;
}

function get_servers_by_date_control($status) {
  global $connect;

  $query = "SELECT days FROM days";
  $res = pg_query($query);
  $days = pg_fetch_object($res);

  if ($status == "done") {
    $query = "SELECT DISTINCT servers.id, servers.name 
			FROM (controls inner join servers on controls.server_id = servers.id)
			WHERE controls.date_control > now() - ('$days->days days')::INTERVAL ";
  } else {
    $query = "SELECT servers.id, servers.name 
		  FROM servers
		  WHERE servers.id not in (SELECT DISTINCT servers.id
		  FROM (controls inner join servers on controls.server_id = servers.id)
		  WHERE controls.date_control > now() - ('$days->days days')::INTERVAL)";
  }
  $res = pg_query($query);
  $server_controls_by_date_control = array();
  while ($r = pg_fetch_object($res))
    $server_controls_by_date_control[] = $r;

  return $server_controls_by_date_control;

}

function get_server_by_name($name) {

  global $connect;
  $query = "SELECT id, name FROM servers WHERE name ilike '%$name%'";
  $res = pg_query($query);
  $server_by_name = pg_fetch_object($res);

  return $server_by_name;
}

function delete_server_by_id($id) {
  global $connect;
  $query = "SELECT * FROM servers WHERE id = $id";
  $res = pg_query($query);
  $controls = pg_fetch_object($res);

  foreach ($controls as $control) {
    $control_id = $controls -> id;
    $query = "DELETE FROM tasks WHERE control_id = $control_id";
    $res = pg_query($query);
    $query = "DELETE FROM controls WHERE server_id = $id";
    $res = pg_query($query);
    $query = "DELETE FROM servers WHERE id = $id";
    $res = pg_query($query);
  }
}

function update_constraint_days($days) {
  var_dump($days);
  $days2 = $days["days"];
  global $connect;
  $query = "UPDATE days SET days='$days2'";
  $res = pg_query($query);
}
?>