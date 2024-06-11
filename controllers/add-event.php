<?php
require_once '../config/connection.php'; 

$valErr = ''; 
$status = 'danger';
$statusMsg = 'Event Added Successfully';

if(isset($_POST['submit'])){ 
    $_SESSION['postData'] = $_POST; 
    $title = !empty($_POST['title'])?trim($_POST['title']):''; 
    $description = !empty($_POST['description'])?trim($_POST['description']):''; 
    $location = !empty($_POST['location'])?trim($_POST['location']):''; 
    $date = !empty($_POST['date'])?trim($_POST['date']):''; 
    $start_time = !empty($_POST['start_time'])?trim($_POST['start_time']):''; 
    $end_time = !empty($_POST['end_time'])?trim($_POST['end_time']):''; 
    
    // Validate form input fields 
    if(empty($title)){ 
        $valErr .= 'Please enter event title.<br/>'; 
    } 
    if(empty($date)){ 
        $valErr .= 'Please enter event date.<br/>'; 
    }else{
        $today = date('Y-m-d');
        if($date < $today)
        {
            $valErr .= 'The selected date cannot be in the past. Please choose a valid date.<br/>'; 
        }
    } 
    if(!empty($start_time) && !empty($end_time))
    {
        if($start_time < $end_time)
        {
            $valErr .= 'The end time must be after the start time. Please select a valid end time.<br/>'; 
        }
    }
    
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Insert data into the database 
        $sqlQ = "INSERT INTO events (title,description,location,date,start_time,end_time,created) VALUES (?,?,?,?,?,?,NOW())"; 
        $stmt = $db->prepare($sqlQ); 
        $stmt->bind_param("ssssss", $db_title, $db_description, $db_location, $db_date, $db_start_time, $db_end_time); 
        $db_title = $title; 
        $db_description = $description; 
        $db_location = $location; 
        $db_date = $date; 
        $db_start_time = $start_time; 
        $db_end_time = $end_time; 
        $insert = $stmt->execute(); 
        
        if($insert){ 
            $event_id = $stmt->insert_id; 
            
            unset($_SESSION['postData']); 
            
            // Store event ID in session 
            $_SESSION['last_event_id'] = $event_id; 
            $status = 'success';
            // header("Location: $googleOauthURL"); 
            // exit(); 
        }else{ 
            $statusMsg = 'Something went wrong, please try again after some time.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}else{ 
    $statusMsg = 'Form submission failed!'; 
} 

$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 

header("Location:" .BASEPATH."index.php"); 
exit(); 

?>