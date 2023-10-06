<?php
$time = 60*60*24*365;
session_set_cookie_params($time, '/');
session_start();


// $task_list = filter_input(INPUT_POST, 'tasklist', FILTER_DEFAULT,  FILTER_REQUIRE_ARRAY);
// if ($task_list === NULL) {
//     $task_list = array();
// }

if (isset($_SESSION['tasklist'])){
    $task_list = $_SESSION['tasklist'];
}else{
    $task_list = array();
}

$action = filter_input(INPUT_POST, 'action');
$errors = array();

switch( $action ) {
    case 'add':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            $task_list[] = $new_task;
        }
        break;
    case 'delete':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
        }
        break;
}
// cap nhat lai sau khi them xoa task list (khong co no thi chi co 1 name(idex))
$_SESSION['tasklist'] = $task_list;

include('task_list.php');
?>