<?php
// Database connection settings
$servername = "betsssqlmi.4c3cc7d9800d.database.windows.net"; // Change if needed
$username = "readonlyuser"; // Your database username
$password = "ZCdEXArz"; // Your database password
$dbname = "CustomerPortalDatabase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query
$sql = "SELECT EventName, eventdate, tournamentname, SportName, Resolved, COUNT(*) as BetSlipCount 
        FROM betslipitem 
        WHERE source = 3 
        AND eventdate BETWEEN '2025-03-22 08:00:00' AND CURRENT_TIMESTAMP 
        AND sportname = 'cricket' 
        AND resolved <> 1 
        GROUP BY eventid, eventname, eventdate, SportName, Resolved, tournamentname 
        ORDER BY eventDate";

$result = isset($_POST['run_query']) ? $conn->query($sql) : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetSlip Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>BetSlip Report</h2>
    <form method="post">
        <button type="submit" name="run_query">Run Query</button>
    </form>
    <table>
        <tr>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Tournament Name</th>
            <th>Sport Name</th>
            <th>Resolved</th>
            <th>BetSlip Count</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["EventName"]) ?></td>
                    <td><?= htmlspecialchars($row["eventdate"]) ?></td>
                    <td><?= htmlspecialchars($row["tournamentname"]) ?></td>
                    <td><?= htmlspecialchars($row["SportName"]) ?></td>
                    <td><?= htmlspecialchars($row["Resolved"]) ?></td>
                    <td><?= htmlspecialchars($row["BetSlipCount"]) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No results found</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
