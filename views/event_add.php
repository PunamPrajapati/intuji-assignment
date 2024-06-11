<div class="container mt-5">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Create an Event</h2>
                    <a class="btn btn-primary btn-sm">Event List</a>
                </div>
                <form action="/submit-event" method="POST">
                    <div class="form-group">
                        <label for="title">Event Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="start-time">Start Time:</label>
                        <input type="time" class="form-control" id="start-time" name="start-time" required>
                    </div>
                    <div class="form-group">
                        <label for="end-time">End Time:</label>
                        <input type="time" class="form-control" id="end-time" name="end-time" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>