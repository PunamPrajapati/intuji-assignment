<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require_once './config/connection.php'; 
        $postData = ''; 
        if(!empty($_SESSION['postData'])){ 
            $postData = $_SESSION['postData']; 
            unset($_SESSION['postData']); 
        } 

        $status = $statusMsg = ''; 
        if(!empty($_SESSION['status_response'])){ 
            $status_response = $_SESSION['status_response']; 
            $status = $status_response['status']; 
            $statusMsg = $status_response['status_msg']; 
        } 
        $sqlQ = "SELECT * FROM `events` ORDER BY `id` DESC"; 
        $stmt = $db->prepare($sqlQ);  
        $stmt->execute(); 
        $result = $stmt->get_result();

        if(isset($_POST['submit'])) {
            $id = $_POST['id'];
            $_SESSION['delete_event_id'] = $id;
            header("Location:".BASEPATH."controllers/google_calendar_event_delete_sync.php");
            exit();
        }
    ?>
    <div class="container mt-5">
        <?php if(!empty($statusMsg)){ ?>
            <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        <?php } unset($_SESSION['status_response']);?>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Create an Event</h2>
                        <form action="controllers/add-event.php" method="POST">
                            <div class="form-group">
                                <label for="title">Event Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required value="<?= !empty($postData['title'])?$postData['title']:''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?= !empty($postData['description'])?$postData['description']:''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" class="form-control" id="location" name="location" required value="<?= !empty($postData['location'])?$postData['location']:''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required value="<?= !empty($postData['date'])?$postData['date']:''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="start-time">Start Time:</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required value="<?= !empty($postData['start_time'])?$postData['start_time']:''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="end-time">End Time:</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required value="<?= !empty($postData['end_time'])?$postData['end_time']:''; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">Events</h2>
                            <?php if(isset($_SESSION['synced']) && $_SESSION['synced'] == 'true'){ ?>
                                <form method="POST" action="controllers/google_calendar_unsync.php">
                                    <button class="btn btn-danger btn-sm" type="submit" name="submit">Disconnect</button>
                                </form>
                            <?php } ?>
                        </div>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i=0;
                                while($eventData = $result->fetch_assoc())
                                {
                                    $i++;
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $eventData['title'] ?></td>
                                    <td><?= $eventData['description'] ?></td>
                                    <td><?= $eventData['location'] ?></td>
                                    <td><?= $eventData['date'] ?></td>
                                    <td><?php 
                                        $start_time = strtotime($eventData['start_time']);
                                        $start_time_formatted = date('h:i A', $start_time);
                                        echo $start_time_formatted;
                                    ?></td>
                                    <td><?php 
                                        $end_time = strtotime($eventData['end_time']);
                                        $end_time_formatted = date('h:i A', $end_time);
                                        echo $end_time_formatted;
                                    ?></td>
                                    <td>
                                        <form method="POST" action="<?php $_PHP_SELF ?>">
                                            <input type="hidden" name="id" value="<?=$eventData['id']?>">
                                            <button class="btn btn-danger btn-sm" name="submit" type="submit">Delete</button>
                                        </form>
                                    
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
