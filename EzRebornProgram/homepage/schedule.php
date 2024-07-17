<?php
session_start();
include('../LogReg/database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT eventName, eventDate, eventDescription FROM events";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$conn->close();

function build_calendar($month, $year, $events) {
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');

    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) { 
        for ($k=0; $k<$dayOfWeek; $k++) {
            $calendar .= "<td class='empty'></td>"; 
        }
    }
    
    $currentDay = 1;

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        
        $currentDate = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $dayEvents = array_filter($events, function($event) use ($currentDate) {
            return $event['eventDate'] == $currentDate;
        });

        $calendar .= "<td class='day' rel='$currentDate'>";
        $calendar .= "<p>$currentDay</p>";

        foreach ($dayEvents as $event) {
            $calendar .= "<p>{$event['eventName']}</p>";
        }

        $calendar .= "</td>";

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i=0; $i<$remainingDays; $i++) {
            $calendar .= "<td class='empty'></td>"; 
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = intval($_GET['month']);
    $year = intval($_GET['year']);
} else {
    $dateComponents = getdate();
    $month = $dateComponents['mon'];
    $year = $dateComponents['year'];
}

$prevMonth = $month == 1 ? 12 : $month - 1;
$prevYear = $month == 1 ? $year - 1 : $year;
$nextMonth = $month == 12 ? 1 : $month + 1;
$nextYear = $month == 12 ? $year + 1 : $year;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Schedule</title>
    <style>
        .calendar {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar th, .calendar td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        .calendar th {
            background-color: #f2f2f2;
        }

        .calendar .day {
            height: 50px;
            vertical-align: top;
        }

        .calendar .empty {
            background-color: #f9f9f9;
        }

        .calendar caption {
            padding: 10px;
            font-size: 1.5em;
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .nav-links a {
            background-color: #bbb;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .nav-links a:hover {
            background-color: #666565;
        }

        .logo {
            max-height: 50px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
        }

        nav ul li a.current {
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="img/EzR Logo.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li class="current"><a href="schedule.php">Events</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="../LogReg/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div id="calendar">
        <div class="nav-links">
            <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>">&laquo; Previous Month</a>
            <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">Next Month &raquo;</a>
        </div>
        <?php echo build_calendar($month, $year, $events); ?>
    </div>
</body>
</html>
