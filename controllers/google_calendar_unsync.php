<?php 
// Include Google calendar api handler class 
include_once 'GoogleClassApi.php'; 

// Include database configuration file 
require_once '../config/connection.php'; 

$statusMsg = ''; 
$status = 'danger'; 

$GoogleCalendarApi = new GoogleCalendarApi(); 

$access_token = $_SESSION['google_access_token']; 
if(!empty($access_token)){ 
    try { 
        $res = $GoogleCalendarApi->UnsyncCalendarEvent($access_token); 
            
        if($res){  
            unset($_SESSION['google_access_token']); 
            unset($_SESSION['synced']); 
                
            $status = 'success'; 
            $statusMsg = '<p>This system is no longer synced with Google Calendar!</p>'; 
        } 
    } catch(Exception $e) { 
        //header('Bad Request', true, 400); 
        //echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() )); 
        $statusMsg = $e->getMessage(); 
    } 
}else{ 
    $statusMsg = 'Failed to fetch access token!'; 
} 
    
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
    
header("Location:" .BASEPATH."index.php"); 
exit(); 
?>