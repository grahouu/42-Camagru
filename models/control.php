<?php
function get_controls($tri=null) {
  global $connect;
  switch ($tri) {
    case 'id-croissant':
      $order_by = "id ASC";
      break;
    case 'id-decroissant':
      $order_by = "id DESC";
      break;
    case 'date-croissante':
      $order_by = "date_control ASC";
      break;
    case 'date-decroissante':
      $order_by = "date_control DESC";
      break;
    case 'type':
      $order_by = "type ASC";
      break;
    default:
      $order_by = "id ASC";
      break;
  }
  $query = "SELECT * FROM controls order by ".$order_by;
  $res = pg_query($connect, $query);
 
  $controls = array();
  while($r = pg_fetch_object($res))
    $controls[] = $r;
 
  return $controls;
}

function create_control($attributes) {
  $tasks = $attributes["tasks"];
  $type = pg_escape_string($attributes["type"]);
  
  if (empty($attributes["date_control"])) {
      return false;
  } else {
    $date_control = $attributes["date_control"];
  }
  
  if (array_key_exists("server_id", $attributes)) {
    if (empty($attributes["server_id"])) {
      return false;
    }
    $server_id = $attributes["server_id"];
  } else {
    $server_id= "NULL";
  }
  
  if (array_key_exists("user_id", $_COOKIE)) {
      $user_id = $_COOKIE['user_id'];
  } else {
    return false;
  }

  global $connect;
  $date = date_to_timestamp(time());

  $query = "INSERT INTO controls (type, date_control, created_at, updated_at, server_id, user_id) 
        VALUES ('$type', '$date_control', '$date', '$date', $server_id, $user_id)";

  $res = pg_query($query);
  
  if(!$res) return false;
  $control=pg_fetch_object($res);
  
  $id = get_control_last_id();
  $control = get_control_by_id($id);
  
  //boucle
  $control_id = array("control_id"=> $control->id);
  foreach ($tasks as $task) {
    $task_attributes = array_merge($task, $control_id);
    if(!create_task($task_attributes)) return false;
  }
  return $control;
}

function update_control_by_id($id, $attributes) {
  $tasks = $attributes["tasks"];
  $update = date_to_timestamp(time());
  global $connect;

  if(empty($attributes["date_control"])) {
    return false;
  } else {
    $date_control = $attributes["date_control"];
  }
  
  if(array_key_exists("user_id", $_COOKIE)) {
    $user_id = $_COOKIE['user_id'];
  } else {
    return false;
  }
  
  $query = "UPDATE controls SET date_control='$date_control', updated_at='$update', user_id=$user_id WHERE id=$id";
  $res = pg_query($query);
  if(!$res) return false;
  $control = get_control_by_id($id);
  
  $control_id = array("control_id"=> $control_id);
  foreach ($tasks as $task) {
    $task_attributes = array_merge($task, $control_id);
    if(!update_task_by_control_id($task_attributes)) return false;
  }

  return $control;
}
  
function get_control_last_id() {
  $query = "SELECT currval('controls_id_seq')";
  $res = pg_query($query);
  $r = pg_fetch_array($res);
  return $r[0];
}

function get_control_max_id() {
  $query = "SELECT max(id) from controls";
  $res = pg_query($query);
  $r = pg_fetch_array($res);
  return $r[0];
}

function get_control_by_id($id) {
  global $connect;
  $id = pg_escape_string(strval($id));
  $query = "SELECT id, type, date_control, created_at, updated_at, user_id, server_id FROM controls WHERE id = $id";
  $res = pg_query($query);
  $control = pg_fetch_object($res);
  
  //db_close_connexion($connect);
  return $control;
}

function delete_control_by_id($id) {
  global $connect;
  
  $query = "DELETE FROM tasks WHERE control_id = $id";
  $res = pg_query($query);
  $query = "DELETE FROM controls WHERE id = $id";
  $res = pg_query($query);
}

?>
