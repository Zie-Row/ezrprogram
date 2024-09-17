<?php
session_start();
include('../LogReg/database.php'); // Include your database connection

// Handle form submissions for adding events
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_event'])) {
        $event_date = $_POST['event_date'];
        $event_title = $_POST['event_title'];
        $event_description = $_POST['event_description'];

        $query = "INSERT INTO esports_events (event_date, event_title, event_description) VALUES ('$event_date', '$event_title', '$event_description')";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['delete_event'])) {
        $event_id = $_POST['event_id'];
        $query = "DELETE FROM esports_events WHERE id = $event_id";
        mysqli_query($conn, $query);
    }
}

// Fetch existing events from the database
$query = "SELECT * FROM esports_events ORDER BY event_date";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Events</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Back Button -->
    <button onclick="window.location.href='home.php'" class="back-btn">Back to Homepage</button>

    <h1>Manage E-Sports Events</h1>

    <form method="POST">
        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" required>
        
        <label for="event_title">Event Title:</label>
        <input type="text" name="event_title" required>

        <label for="event_description">Event Description (optional):</label>
        <textarea name="event_description"></textarea>

        <button type="submit" name="add_event">Add Event</button>
    </form>

    <h2>Existing Events</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['event_title']; ?></td>
            <td><?php echo $row['event_description']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete_event">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
