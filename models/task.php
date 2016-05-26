<?php
function create_task ($attributes){
  $date = date_to_timestamp(time());
  $control_id = $attributes['control_id'];
  $status = ($attributes['status'] == 1) ? 'TRUE' : 'FALSE';

  $comment = pg_escape_string($attributes['comment']);
  $type = pg_escape_string($attributes['type']);
  $verification_time = pg_escape_string($attributes['verification_time']);

  global $connect;

  $query = "INSERT INTO tasks (status, comment, created_at, updated_at, type, control_id, verification_time) 
  VALUES ($status, '$comment', '$date', '$date', '$type', $control_id, '$verification_time')";
  $res = pg_query($query);

  if(!$res) return false;
  pg_fetch_object($res);
  $id=get_task_last_id();
  $task = get_task_by_id($id);
  
  return $task;
}

function get_task_last_id() {
  $query = "SELECT currval('tasks_id_seq')";
  $res = pg_query($query);
  $r = pg_fetch_array($res);
  
  return $r[0];
}

function get_tasks_by_control_id($id){
  global $connect;
  $query = "SELECT * FROM tasks WHERE control_id = $id";
  $res = pg_query($connect, $query);
 
  $tasks= array();
  while($r = pg_fetch_object($res))
    $tasks[] = $r;
 
  return $tasks;
}

function get_task_by_id($id){
  global $connect;
  $id = pg_escape_string(strval($id));
  $query = "SELECT id, status,comment, created_at, updated_at, type, control_id FROM tasks WHERE id=$id";
  $res = pg_query($query);
  $task = pg_fetch_object($res);
  
  return $task;
}

function update_task_by_control_id ($attributes){
  $date = date_to_timestamp(time());
  $control_id = $attributes['control_id'];

  $status = ($attributes['status'] == 1) ? 'TRUE' : 'FALSE';

  $comment = pg_escape_string($attributes['comment']);
  $verification_time = pg_escape_string($attributes['verification_time']);
  global $connect;
  
  $id=$attributes['id'];
  $query = "UPDATE tasks SET status=$status, comment='$comment', updated_at='$date', verification_time='$verification_time' WHERE id=$id ";
  $res = pg_query($query);

  if(!$res) return false;
  pg_fetch_object($res);

  $task = get_task_by_id($id);
  
  return $task;
}
  
?>
