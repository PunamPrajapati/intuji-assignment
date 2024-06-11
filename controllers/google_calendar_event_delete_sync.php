<?php 
// Include Google calendar api handler class 
include_once 'GoogleClassApi.php'; 
     
// Include database configuration file 
require_once '../config/connection.php'; 
 
$statusMsg = ''; 
$status = 'danger'; 

// Initialize Google Calendar API class 
$GoogleCalendarApi = new GoogleCalendarApi(); 
    
// Get event ID from session 
$event_id = $_SESSION['delete_event_id']; 
if(!empty($event_id)){ 
        
    // Fetch event details from database 
    $sqlQ = "SELECT * FROM events WHERE id = ?"; 
    $stmt = $db->prepare($sqlQ);  
    $stmt->bind_param("i", $db_event_id); 
    $db_event_id = $event_id; 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
    $eventData = $result->fetch_assoc(); 
    if(!empty($eventData)){ 
        $sql = "DELETE FROM `events` WHERE `id` = $event_id" ;
        $stmt = $db->prepare($sql);  
        $delete = $stmt->execute(); 
        if($delete)
        {
            $google_event_id = $eventData['google_calendar_event_id'];
                
            // Get the access token 
            $access_token = $_SESSION['google_access_token']; 
            
            if(!empty($access_token)){ 
                try { 
                    // Create an event on the primary calendar 
                    $res = $GoogleCalendarApi->DeleteCalendarEvent($access_token, 'primary', $google_event_id); 
                    //echo json_encode([ 'event_id' => $event_id ]); 
                        
                    if($res){  
                        unset($_SESSION['delete_event_id']); 
                        // unset($_SESSION['google_access_token']); 
                            
                        $status = 'success'; 
                        $statusMsg = '<p>Event #'.$event_id.' has been deleted from Google Calendar successfully!</p>'; 
                        $statusMsg .= '<p><a href="https://calendar.google.com/calendar/" target="_blank">Open Calendar</a>'; 
                    } 
                } catch(Exception $e) { 
                    //header('Bad Request', true, 400); 
                    //echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() )); 
                    $statusMsg = $e->getMessage(); 
                } 
            }else{ 
                $statusMsg = 'Failed to fetch access token!'; 
            } 
        }else{
            $statusMsg = 'Failed to delete!'; 
        }
    }else{ 
        $statusMsg = 'Event data not found!'; 
    } 
}else{ 
    $statusMsg = 'Event reference not found!'; 
} 
    
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
    
header("Location:" .BASEPATH."index.php"); 
exit(); 
?>