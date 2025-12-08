<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_reservation_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../pages/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

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

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: reservation_details.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update_id'])) {
        $update_id = intval($_POST['update_id']);
        $room_id = intval($_POST['room_id']);
        $payment_type = $_POST['payment_type'] ?? null;
        $options = isset($_POST['options']) ? implode(',', $_POST['options']) : null;
        $checkin_date = $_POST['checkin_date'] ?? date("Y-m-d");
        $checkout_date = $_POST['checkout_date'] ?? date("Y-m-d");

        $stmt = $conn->prepare("
            UPDATE reservations 
            SET room_id=?, payment_type=?, options=?, status='Pending', 
                checkin_date=?, checkout_date=? 
            WHERE id=? AND user_id=?
        ");
        $stmt->bind_param("issssii", $room_id, $payment_type, $options, $checkin_date, $checkout_date, $update_id, $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: reservation_details.php");
        exit;
    }

    if (isset($_POST['room_ids'])) {
        foreach ($_POST['room_ids'] as $room_id) {
            $payment_type = $_POST['payment_type'][$room_id] ?? null;
            $options = isset($_POST['options'][$room_id]) ? implode(',', $_POST['options'][$room_id]) : null;
            $checkin_date = $_POST['checkin_date'][$room_id] ?? date("Y-m-d");
            $checkout_date = $_POST['checkout_date'][$room_id] ?? date("Y-m-d");

            $stmt = $conn->prepare("
                INSERT INTO reservations (user_id, room_id, payment_type, options, status, checkin_date, checkout_date) 
                VALUES (?, ?, ?, ?, 'Pending', ?, ?)
            ");
            $stmt->bind_param("iissss", $user_id, $room_id, $payment_type, $options, $checkin_date, $checkout_date);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: reservation_details.php");
        exit;
    }
}

$stmt = $conn->prepare("
    SELECT r.*, u_info.name, u_info.phone, u.email, r.staff_notification, r.staff_approved
    FROM reservations r
    LEFT JOIN user_info u_info ON r.user_id = u_info.user_id
    LEFT JOIN users u ON r.user_id = u.id
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$editData = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id=? AND user_id=? LIMIT 1");
    $stmt->bind_param("ii", $edit_id, $user_id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Reservations</title>

<style>
body {
    font-family: Arial;
    margin: 20px;
    background-image: url('../assets/hotel6.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}
.main-container {
    background: rgba(255,255,255,0.92);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0,0,0,0.25);
}
table { 
    width:100%; 
    border-collapse:collapse; 
    margin-bottom:25px;
    background:white;
}
th, td { 
    border:1px solid #ccc; 
    padding:8px; 
    text-align:center; 
}
th { 
    background:#eee; 
}
.status-pending { color:orange; font-weight:bold; }
.status-approved { color:green; font-weight:bold; }
.status-cancelled, .status-unavailable { color:red; font-weight:bold; }
.update-box { 
    border:2px solid #333; 
    padding:20px; 
    background:#ffffffd9; 
    width:50%; 
    margin:auto;
    border-radius:10px;
}
button {
    padding:6px 14px;
    background:#0066cc;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
button:hover {
    background:#004c99;
}

.modal {
    display:none;
    position: fixed;
    z-index: 100;
    left:0; top:0;
    width:100%; height:100%;
    overflow:auto;
    background-color: rgba(0,0,0,0.6);
}
.modal-content {
    background:#fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 60%;
    box-shadow: 0 5px 25px rgba(0,0,0,0.3);
}
.close {
    color:#aaa;
    float:right;
    font-size:28px;
    font-weight:bold;
    cursor:pointer;
}
.close:hover { color:black; }
</style>
</head>
<body>

<div class="main-container">

<h2>Your Reservations</h2>
<p style="color:blue;"><strong>Note:</strong> Your reservations are listed below with their current status.</p>

<?php if ($result->num_rows > 0): ?>
<table>
<tr>
    <th>Reservation ID</th>
    <th>Room ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Room Title</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Payment</th>
    <th>Options</th>
    <th>Total Price (₱)</th>
    <th>Status</th>
    <th>Created At</th>
    <th>Notification</th>
    <th>View</th>
    <th>Update</th>
    <th>Delete</th>
</tr>

<?php while($row = $result->fetch_assoc()):
    $room_id = $row['room_id'];
    $room_title = $rooms[$room_id]['title'] ?? "Unknown Room";
    $room_price = $rooms[$room_id]['price'] ?? 0;

    $days = max(1, (strtotime($row['checkout_date']) - strtotime($row['checkin_date'])) / 86400);

    $options = $row['options'] ? explode(',', $row['options']) : [];
    $extras_price = 0;
    foreach ($options as $opt) if(isset($option_prices[$opt])) $extras_price += $option_prices[$opt];

    $total_price = ($room_price * $days) + $extras_price;

    if($row['staff_approved'] == 1 && $row['status'] == 'Pending') {
        $displayStatus = 'Approved by Staff';
    } elseif($row['staff_approved'] == 1 && $row['status'] == 'Approved') {
        $displayStatus = 'Approved';
    } elseif($row['status'] == 'Cancelled') {
        $displayStatus = 'Cancelled';
    } elseif($row['status'] == 'Unavailable') {
        $displayStatus = 'Unavailable';
    } else {
        $displayStatus = 'Pending';
    }

    $statusClass = 'status-'.strtolower(str_replace(' ', '-', $displayStatus));
    $notification = $row['staff_notification'] ?? '-';
?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $room_id; ?></td>
    <td><?= htmlspecialchars($row['name'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($row['email'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($row['phone'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($room_title); ?></td>
    <td><?= $row['checkin_date']; ?></td>
    <td><?= $row['checkout_date']; ?></td>
    <td><?= $row['payment_type'] ?? '-'; ?></td>
    <td><?= $row['options'] ?? '-'; ?></td>
    <td><?= number_format($total_price,2); ?></td>
    <td class="<?= $statusClass; ?>"><?= htmlspecialchars($displayStatus); ?></td>
    <td><?= $row['created_at']; ?></td>
    <td><?= htmlspecialchars($notification); ?></td>

    <td>
        <button class="view-btn" 
            data-id="<?= $row['id']; ?>" 
            data-room="<?= $room_title; ?>" 
            data-checkin="<?= $row['checkin_date']; ?>" 
            data-checkout="<?= $row['checkout_date']; ?>" 
            data-payment="<?= $row['payment_type'] ?? '-'; ?>"
            data-options="<?= htmlspecialchars(implode('<br>', $options), ENT_QUOTES); ?>"
            data-total="<?= number_format($total_price,2); ?>"
            data-status="<?= htmlspecialchars($displayStatus); ?>"
            data-username="<?= htmlspecialchars($row['name'] ?? '-'); ?>"
            data-email="<?= htmlspecialchars($row['email'] ?? '-'); ?>"
            data-phone="<?= htmlspecialchars($row['phone'] ?? '-'); ?>"
            data-notification="<?= htmlspecialchars($notification); ?>"
        >View</button>
    </td>

    <td>
        <form method="GET">
            <input type="hidden" name="edit_id" value="<?= $row['id']; ?>">
            <button type="submit">Update</button>
        </form>
    </td>

    <td>
        <form method="GET" onsubmit="return confirm('Are you sure you want to delete this reservation?');">
            <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>You have no reservations yet.</p>
<?php endif; ?>

<?php if ($editData): ?>
<div class="update-box">
<h3>Update Reservation #<?= $editData['id']; ?></h3>
<form method="POST">
    <input type="hidden" name="update_id" value="<?= $editData['id']; ?>">

    <label><strong>Select Room:</strong></label><br>
    <select name="room_id" required>
        <?php foreach ($rooms as $r_id => $r): ?>
            <option value="<?= $r_id; ?>" <?= ($editData['room_id'] == $r_id) ? 'selected' : ''; ?>>
                <?= $r['title']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label><strong>Check-in Date:</strong></label><br>
    <input type="date" name="checkin_date" value="<?= $editData['checkin_date']; ?>" required><br><br>

    <label><strong>Check-out Date:</strong></label><br>
    <input type="date" name="checkout_date" value="<?= $editData['checkout_date']; ?>" required><br><br>

    <label><strong>Payment Type:</strong></label><br>
    <select name="payment_type" required>
        <?php 
        $paymentOptions = ["Cash","GCash","Credit Card","PayPal"];
        foreach ($paymentOptions as $p): ?>
        <option value="<?= $p; ?>" <?= ($editData['payment_type'] == $p) ? 'selected' : ''; ?>><?= $p; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label><strong>Options:</strong></label><br>
    <?php 
    $selectedOptions = $editData['options'] ? explode(",", $editData['options']) : [];
    foreach ($option_prices as $opt=>$price): ?>
        <label>
            <input type="checkbox" name="options[]" value="<?= $opt; ?>"
                <?= in_array($opt, $selectedOptions) ? 'checked' : ''; ?>>
            <?= $opt . " (+₱$price)"; ?>
        </label><br>
    <?php endforeach; ?>

    <br>
    <button type="submit">Save Changes</button>
</form>
</div>
<?php endif; ?>

</div> 

<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Reservation Details</h3>
        <p><strong>Reservation ID:</strong> <span id="resId"></span></p>
        <p><strong>User Name:</strong> <span id="resUsername"></span></p>
        <p><strong>Email:</strong> <span id="resEmail"></span></p>
        <p><strong>Phone:</strong> <span id="resPhone"></span></p>
        <p><strong>Room:</strong> <span id="resRoom"></span></p>
        <p><strong>Check-in:</strong> <span id="resCheckin"></span></p>
        <p><strong>Check-out:</strong> <span id="resCheckout"></span></p>
        <p><strong>Payment:</strong> <span id="resPayment"></span></p>
        <p><strong>Options:</strong><br><span id="resOptions"></span></p>
        <p><strong>Total Price:</strong> ₱<span id="resTotal"></span></p>
        <p><strong>Status:</strong> <span id="resStatus"></span></p>
        <p><strong>Notification:</strong> <span id="resNotification"></span></p>
    </div>
</div>

<script>
const modal = document.getElementById('viewModal');
const spanClose = document.querySelector('.close');
const viewButtons = document.querySelectorAll('.view-btn');

viewButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('resId').textContent = btn.dataset.id;
        document.getElementById('resUsername').textContent = btn.dataset.username;
        document.getElementById('resEmail').textContent = btn.dataset.email;
        document.getElementById('resPhone').textContent = btn.dataset.phone;
        document.getElementById('resRoom').textContent = btn.dataset.room;
        document.getElementById('resCheckin').textContent = btn.dataset.checkin;
        document.getElementById('resCheckout').textContent = btn.dataset.checkout;
        document.getElementById('resPayment').textContent = btn.dataset.payment;
        document.getElementById('resOptions').innerHTML = btn.dataset.options;
        document.getElementById('resTotal').textContent = btn.dataset.total;
        document.getElementById('resStatus').textContent = btn.dataset.status;
        document.getElementById('resNotification').textContent = btn.dataset.notification;

        modal.style.display = 'block';
    });
});

spanClose.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

</body>
</html>

<?php $conn->close(); ?>
