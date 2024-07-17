<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
</head>
<body>
    <nav class="content">
        <h2>Events</h2>
        <div class="form-container">
            <form action="../admin/eventsmanagement/submitevent.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="eventName">Event Name:</label>
                    <input type="text" id="eventName" name="eventName" required>
                </div>
                <div class="form-group">
                    <label for="eventDate">Event Date:</label>
                    <input type="date" id="eventDate" name="eventDate" required>
                </div>
                <div class="form-group">
                    <label for="eventDescription">Event Description:</label>
                    <textarea id="eventDescription" name="eventDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label for="eventPhoto">Event Photo:</label>
                    <input type="file" id="eventPhoto" name="eventPhoto" accept="image/*" required>
                </div>
                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </nav>
</body>
</html>
