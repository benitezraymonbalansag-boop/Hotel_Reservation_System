<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_reservation_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

$rooms = [
    1 => ["title"=>"Ocean View Suite","price"=>3500.00],
    2 => ["title"=>"Deluxe King Room","price"=>2200.00],
    3 => ["title"=>"Standard Queen Room","price"=>1500.00],
    4 => ["title"=>"Family Suite","price"=>4000.00],
    5 => ["title"=>"Executive Room","price"=>2800.00],
    6 => ["title"=>"Mountain View Room","price"=>1700.00],
    7 => ["title"=>"Luxury Penthouse","price"=>6500.00],
    8 => ["title"=>"Twin Bed Room","price"=>1600.00],
    9 => ["title"=>"Presidential Suite","price"=>8500.00],
    10 => ["title"=>"Garden Villa","price"=>5000.00],
];

$option_prices = [
    "Free Breakfast"=>250,
    "Airport Pickup"=>500,
    "Full Package"=>1000,
    "Spa Access"=>700,
    "Late Checkout"=>300
];

// Handle Approve
if (isset($_GET['approve_id'])) {
    $id = intval($_GET['approve_id']);
    $stmt = $conn->prepare("
        UPDATE reservations 
        SET status='Approved', 
            admin_approved=1,
            admin_notification='Your reservation has been approved by admin.'
        WHERE id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Handle Cancel
if (isset($_GET['cancel_id'])) {
    $id = intval($_GET['cancel_id']);
    $stmt = $conn->prepare("
        UPDATE reservations 
        SET status='Cancelled', 
            admin_notification='Your reservation has been cancelled by admin.'
        WHERE id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Handle Unavailable
if (isset($_GET['unavailable_id'])) {
    $id = intval($_GET['unavailable_id']);
    $stmt = $conn->prepare("
        UPDATE reservations 
        SET status='Unavailable', 
            admin_notification='Your reservation has been marked unavailable by admin.'
        WHERE id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("UPDATE reservations SET admin_deleted=1 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Fetch Reservations
$stmt = $conn->prepare("
    SELECT r.*, u_info.name, u_info.phone, u.email
    FROM reservations r
    LEFT JOIN user_info u_info ON r.user_id = u_info.user_id
    LEFT JOIN users u ON r.user_id = u.id
    WHERE r.admin_deleted=0
    ORDER BY r.created_at DESC
");
$stmt->execute();
$allReservations = $stmt->get_result();
$stmt->close();

$pending = $approved = $cancelled = $unavailable = [];
while ($row = $allReservations->fetch_assoc()) {
    if ($row['status'] === 'Approved') $approved[] = $row;
    elseif ($row['status'] === 'Cancelled') $cancelled[] = $row;
    elseif ($row['status'] === 'Unavailable') $unavailable[] = $row;
    else $pending[] = $row;
}

function renderTable($reservations, $rooms, $option_prices, $statusType) {
    if (empty($reservations)) {
        echo "<p>No $statusType reservations.</p>";
        return;
    }

    echo '<table>
    <tr>
        <th>Reservation ID</th>
        <th>Room ID</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Room Title</th>
        <th>Days Staying</th>
        <th>Payment Type</th>
        <th>Options</th>
        <th>Total Price (₱)</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Staff Approval</th>
        <th>Admin Approval</th>
        <th>Approve</th>
        <th>Cancel</th>
        <th>Unavailable</th>
    </tr>';

    foreach ($reservations as $row) {
        $room_id = $row['room_id'];
        $room_title = $rooms[$room_id]['title'] ?? "Unknown Room";
        $room_price = $rooms[$room_id]['price'] ?? 0;
        $days = $row['days_staying'] ?? 1;

        $options = $row['options'] ? explode(",", $row['options']) : [];
        $extras_price = 0;
        foreach ($options as $opt) if (isset($option_prices[$opt])) $extras_price += $option_prices[$opt];

        $total_price = ($room_price * $days) + $extras_price;
        $displayStatus = $row['status'];

        // Status Class for Styling
        $statusClass = match($displayStatus) {
            'Approved' => 'status-approved',
            'Pending' => 'status-pending',
            'Cancelled' => 'status-cancelled',
            'Unavailable' => 'status-unavailable',
            default => ''
        };

        echo '<tr class="'.$statusClass.'">';
        echo "<td>{$row['id']}</td>";
        echo "<td>{$room_id}</td>";
        echo "<td>".htmlspecialchars($row['name'])."</td>";
        echo "<td>".htmlspecialchars($row['email'])."</td>";
        echo "<td>".htmlspecialchars($row['phone'])."</td>";
        echo "<td>{$room_title}</td>";
        echo "<td>{$days}</td>";
        echo "<td>".($row['payment_type'] ?? '-')."</td>";
        echo "<td>".($row['options'] ?: '-')."</td>";
        echo "<td>".number_format($total_price, 2)."</td>";
        echo "<td>{$displayStatus}</td>";
        echo "<td>{$row['created_at']}</td>";
        echo "<td>".($row['staff_approved'] ? 'Yes' : 'No')."</td>";
        echo "<td>".($row['admin_approved'] ? 'Yes' : 'No')."</td>";

        // Buttons
        echo "<td><form method='GET'><input type='hidden' name='approve_id' value='{$row['id']}'><button type='submit' class='btn-approve'>Approve</button></form></td>";
        echo "<td>";
        if ($displayStatus !== 'Cancelled') echo "<form method='GET'><input type='hidden' name='cancel_id' value='{$row['id']}'><button type='submit' class='btn-cancel'>Cancel</button></form>";
        else echo "-";
        echo "</td>";
        echo "<td>";
        if ($displayStatus !== 'Unavailable') echo "<form method='GET'><input type='hidden' name='unavailable_id' value='{$row['id']}'><button type='submit' class='btn-unavailable'>Unavailable</button></form>";
        else echo "-";
        echo "</td>";
        echo "</tr>";
    }

    echo '</table><br>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reservations Dashboard</title>
<style>
/* Body & Headings */
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:20px; background:#f9f9f9; color:#333; }
h1 { color:#1e3d59; font-size:28px; margin-bottom:15px; }
h2 { color:#3e5c76; font-size:22px; margin-top:30px; margin-bottom:10px; }

/* Table Styling */
table { width:100%; border-collapse:collapse; margin-bottom:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1); background:#fff; border-radius:8px; overflow:hidden; }
table th, table td { padding:12px 8px; text-align:center; }
table th { background:#1e3d59; color:white; font-weight:600; }
table tr:nth-child(even) { background:#f2f2f2; }
table tr:hover { background:#d0e6ff; transition:0.2s; }

/* Buttons */
button { padding:6px 12px; border:none; border-radius:5px; cursor:pointer; font-weight:500; transition:all 0.2s ease; }
button:hover { opacity:0.85; }

/* Status Buttons */
.btn-approve { background:#4CAF50; color:white; }
.btn-cancel { background:#FF8C00; color:white; }
.btn-unavailable { background:#888; color:white; }

/* Status Row Colors */
.status-approved { background:#c8f0c8; }
.status-pending { background:#fff3b3; }
.status-cancelled { background:#ffd699; }
.status-unavailable { background:#f0b3b3; }

/* Responsive */
@media (max-width:1200px) { table th, table td { padding:10px 5px; font-size:14px; } }
@media (max-width:768px) { table { font-size:12px; } h1 { font-size:22px; } h2 { font-size:18px; } }
</style>
</head>
<body>

<h1>Reservations Dashboard</h1>

<h2>Pending Reservations</h2>
<?php renderTable($pending, $rooms, $option_prices, 'Pending'); ?>

<h2>Approved Reservations</h2>
<?php renderTable($approved, $rooms, $option_prices, 'Approved'); ?>

<h2>Cancelled Reservations</h2>
<?php renderTable($cancelled, $rooms, $option_prices, 'Cancelled'); ?>

<h2>Unavailable Reservations</h2>
<?php renderTable($unavailable, $rooms, $option_prices, 'Unavailable'); ?>

</body>
</html>

<?php $conn->close(); ?>
