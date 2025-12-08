<?php 
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../pages/login.php");
    exit;
}

require_once "../Classes/Connection.php"; 
$dbh = new Dbh();
$conn = $dbh->connect();

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

$today = date("Y-m-d");

if (isset($_GET['action']) && isset($_GET['id'])) {
    $res_id = intval($_GET['id']);
    $action = $_GET['action'];

    if (in_array($action, ['Approved','Cancelled'])) {
        if($action === 'Approved'){
            $note = "Staff approved, awaiting admin approval";
            $stmt = $conn->prepare("UPDATE reservations SET staff_approved=1, status='Pending', staff_notification=? WHERE id=?");
            $stmt->bind_param("si", $note, $res_id);
        } else {
            $stmt = $conn->prepare("UPDATE reservations SET status='Cancelled', staff_notification='Cancelled by staff' WHERE id=?");
            $stmt->bind_param("i", $res_id);
        }
        $stmt->execute();
        $stmt->close();
        header("Location: todays_reservations.php");
        exit;
    }
}

$query = "
    SELECT r.*, u_info.name, u_info.phone, u.email
    FROM reservations r
    LEFT JOIN user_info u_info ON r.user_id = u_info.user_id
    LEFT JOIN users u ON r.user_id = u.id
    WHERE r.checkin_date = ?
      AND r.admin_deleted = 0
    ORDER BY r.created_at ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Today's Reservations</title>
    <style>
        body { font-family: Arial; margin:20px; }
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #ccc; padding:8px; text-align:center; }
        th { background:#f2f2f2; }
        .status-pending { color:orange; font-weight:bold; }
        .status-approved { color:green; font-weight:bold; }
        .status-cancelled { color:red; font-weight:bold; }
        .btn { padding:4px 8px; margin:2px; cursor:pointer; }
        .btn-approve { background:green; color:white; border:none; }
        .btn-cancel { background:red; color:white; border:none; }
    </style>
</head>
<body>

<h1>Today's Reservations (<?php echo $today; ?>)</h1>
<a href="dashboard.php">Back to Dashboard</a> | 
<a href="../handlers/logout.php">Logout</a>
<br><br>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th><th>Room</th><th>Title</th><th>Guest</th><th>Email</th>
            <th>Phone</th><th>Payment</th><th>Options</th><th>Total (₱)</th>
            <th>Check-in</th><th>Check-out</th><th>Status</th><th>Staff Approved</th><th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $room_id = $row['room_id'];
        $room_title = $rooms[$room_id]['title'] ?? "Unknown Room";
        $room_price = $rooms[$room_id]['price'] ?? 0;

        $checkin_date = $row['checkin_date'];
        $checkout_date = $row['checkout_date'];
        $days = max(1, (strtotime($checkout_date) - strtotime($checkin_date)) / 86400);

        $options = $row['options'] ? explode(',', $row['options']) : [];
        $extras_price = 0; foreach ($options as $opt) if(isset($option_prices[$opt])) $extras_price += $option_prices[$opt];

        $total_price = ($room_price * $days) + $extras_price;
        $statusClass = 'status-'.strtolower($row['status']);
        $staffApproved = intval($row['staff_approved']) === 1 ? 'Yes' : 'No';
        
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$room_id}</td>
                <td>".htmlspecialchars($room_title)."</td>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['phone'])."</td>
                <td>".($row['payment_type'] ?? '-')."</td>
                <td>".($row['options'] ?? '-')."</td>
                <td>".number_format($total_price,2)."</td>
                <td>{$checkin_date}</td>
                <td>{$checkout_date}</td>
                <td class='{$statusClass}'>".htmlspecialchars($row['status'])."</td>
                <td>{$staffApproved}</td>
                <td>";

        if ($staffApproved === 'No' && strtolower($row['status']) !== 'cancelled') {
            echo "<a class='btn btn-approve' href='?action=Approved&id={$row['id']}'>Approve</a>";
            echo "<a class='btn btn-cancel' href='?action=Cancelled&id={$row['id']}'>Cancel</a>";
        } else {
            echo "-";
        }

        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No reservations scheduled for today.</p>";
}

$stmt->close();
$conn->close();
?>
</body>
</html>
