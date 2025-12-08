<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../pages/login.php");
    exit;
}

// Rooms array (10 sample rooms)
$rooms = [
    ["id"=>1,"title"=>"Ocean View Suite","type"=>"Suite","description"=>"A luxury suite with an amazing ocean view.","price"=>3500.00,"capacity"=>4,"image"=>"room1.jpg"],
    ["id"=>2,"title"=>"Deluxe King Room","type"=>"Deluxe","description"=>"Spacious room with king-size bed and modern amenities.","price"=>2200.00,"capacity"=>2,"image"=>"room2.jpg"],
    ["id"=>3,"title"=>"Standard Queen Room","type"=>"Standard","description"=>"Affordable room with queen-size bed.","price"=>1500.00,"capacity"=>2,"image"=>"room3.jpg"],
    ["id"=>4,"title"=>"Family Suite","type"=>"Suite","description"=>"Perfect for families, with 2 beds and a living area.","price"=>4000.00,"capacity"=>5,"image"=>"room4.jpg"],
    ["id"=>5,"title"=>"Executive Room","type"=>"Executive","description"=>"High-end executive room with workspace.","price"=>2800.00,"capacity"=>2,"image"=>"room5.jpg"],
    ["id"=>6,"title"=>"Mountain View Room","type"=>"Standard","description"=>"Room with a relaxing mountain view.","price"=>1700.00,"capacity"=>2,"image"=>"room6.jpg"],
    ["id"=>7,"title"=>"Luxury Penthouse","type"=>"Penthouse","description"=>"Top floor luxury penthouse with premium amenities.","price"=>6500.00,"capacity"=>6,"image"=>"room7.jpg"],
    ["id"=>8,"title"=>"Twin Bed Room","type"=>"Standard","description"=>"Room with twin beds, ideal for friends.","price"=>1600.00,"capacity"=>2,"image"=>"room8.jpg"],
    ["id"=>9,"title"=>"Presidential Suite","type"=>"Suite","description"=>"Premium suite with large living area and VIP features.","price"=>8500.00,"capacity"=>8,"image"=>"room9.jpg"],
    ["id"=>10,"title"=>"Garden Villa","type"=>"Villa","description"=>"Private villa surrounded by garden scenery.","price"=>5000.00,"capacity"=>4,"image"=>"room10.jpg"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Select Rooms</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url('../images/hotel5.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        padding: 20px;
    }

    form {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        max-width: 1200px;
        margin: auto;
        box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    }

    h1 {
        text-align: center;
        margin-bottom: 25px;
        color: #003366;
    }

    table { 
        border-collapse: collapse; 
        width: 100%; 
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
    }
    th, td { 
        padding: 10px; 
        border: 1px solid #f0e8e8ff; 
        text-align: center; 
    }
    th {
        background: #1e90ff;
        color: white;
    }

    img { 
        width: 150px; 
        border-radius: 6px; 
    }

    button { 
        padding: 10px 20px; 
        background: #1e90ff; 
        border: none; 
        color: white; 
        border-radius: 6px; 
        cursor: pointer; 
        font-size: 16px;
    }
    button:hover { 
        background: #0b63c8; 
    }

    .room-options { 
        margin: 15px 0; 
        padding: 10px; 
        border: 1px dashed #999; 
        border-radius: 6px; 
        display: none; 
        text-align: left; 
        background: #f9f9f9;
    }

    input, select { 
        padding: 6px; 
        margin: 5px 0; 
        width: 250px; 
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .checkbox-group label { 
        display: block; 
        margin-bottom: 5px; 
    }

    .missing { 
        border: 2px solid red; 
    }
</style>
<script>
function toggleRoomOptions(roomId) {
    const optionsDiv = document.getElementById('options-' + roomId);
    const checkbox = document.getElementById('room-' + roomId);
    optionsDiv.style.display = checkbox.checked ? 'block' : 'none';

    const paymentSelect = optionsDiv.querySelector('select[name="payment_type['+roomId+']"]');
    const checkinInput = optionsDiv.querySelector('input[name="checkin_date['+roomId+']"]');
    const checkoutInput = optionsDiv.querySelector('input[name="checkout_date['+roomId+']"]');

    if (checkbox.checked) {
        paymentSelect.setAttribute('required', 'required');
        checkinInput.setAttribute('required', 'required');
        checkoutInput.setAttribute('required', 'required');
    } else {
        paymentSelect.removeAttribute('required');
        checkinInput.removeAttribute('required');
        checkoutInput.removeAttribute('required');
        paymentSelect.classList.remove('missing');
        checkinInput.classList.remove('missing');
        checkoutInput.classList.remove('missing');
    }
}

function validateForm(event) {
    const checkboxes = document.querySelectorAll('input[name="room_ids[]"]');
    let anyChecked = false;
    let missingFields = [];

    checkboxes.forEach(cb => {
        if(cb.checked) {
            anyChecked = true;
            const optionsDiv = document.getElementById('options-' + cb.value);
            const paymentSelect = optionsDiv.querySelector('select[name="payment_type['+cb.value+']"]');
            const checkinInput = optionsDiv.querySelector('input[name="checkin_date['+cb.value+']"]');
            const checkoutInput = optionsDiv.querySelector('input[name="checkout_date['+cb.value+']"]');

            paymentSelect.classList.remove('missing');
            checkinInput.classList.remove('missing');
            checkoutInput.classList.remove('missing');

            if (!paymentSelect.value) missingFields.push(paymentSelect);
            if (!checkinInput.value) missingFields.push(checkinInput);
            if (!checkoutInput.value) missingFields.push(checkoutInput);
        }
    });

    if (!anyChecked) {
        alert('Please select at least one room before booking.');
        event.preventDefault();
        return false;
    }

    if (missingFields.length > 0) {
        missingFields.forEach(el => el.classList.add('missing'));
        alert('Please fill out all required fields for the selected rooms.');
        event.preventDefault();
        return false;
    }
}
</script>
</head>
<body>
<h1>Select Rooms</h1>

<form action="reservation_details.php" method="POST" onsubmit="validateForm(event)">
    <table>
        <tr>
            <th>Select</th>
            <th>Image</th>
            <th>Title</th>
            <th>Type</th>
            <th>Description</th>
            <th>Capacity</th>
            <th>Price</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td>
                <input type="checkbox" name="room_ids[]" value="<?= $room['id'] ?>" id="room-<?= $room['id'] ?>" onclick="toggleRoomOptions(<?= $room['id'] ?>)">
            </td>
            <td><img src="../images/<?= $room['image'] ?>" alt="<?= $room['title'] ?>"></td>
            <td><?= $room['title'] ?></td>
            <td><?= $room['type'] ?></td>
            <td><?= $room['description'] ?></td>
            <td><?= $room['capacity'] ?></td>
            <td>₱<?= number_format($room['price'], 2) ?></td>
        </tr>
        <tr id="options-<?= $room['id'] ?>" class="room-options">
            <td colspan="7">
                <strong>Booking Details for <?= $room['title'] ?>:</strong><br>
                Check-in Date: 
                <input type="date" name="checkin_date[<?= $room['id'] ?>]" value="<?= date('Y-m-d') ?>"><br>
                Check-out Date: 
                <input type="date" name="checkout_date[<?= $room['id'] ?>]" value="<?= date('Y-m-d', strtotime('+1 day')) ?>"><br>
                Payment Type:
                <select name="payment_type[<?= $room['id'] ?>]">
                    <option value="">-- Select Payment Type --</option>
                    <option value="Cash">Cash</option>
                    <option value="GCash">GCash</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                </select><br>
                Additional Options:<br>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="options[<?= $room['id'] ?>][]" value="Free Breakfast"> Free Breakfast (+₱250)</label>
                    <label><input type="checkbox" name="options[<?= $room['id'] ?>][]" value="Airport Pickup"> Airport Pickup (+₱500)</label>
                    <label><input type="checkbox" name="options[<?= $room['id'] ?>][]" value="Full Package"> Full Package (+₱1000)</label>
                    <label><input type="checkbox" name="options[<?= $room['id'] ?>][]" value="Spa Access"> Spa Access (+₱700)</label>
                    <label><input type="checkbox" name="options[<?= $room['id'] ?>][]" value="Late Checkout"> Late Checkout (+₱300)</label>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit" style="margin-top: 20px;">Book Selected Rooms</button>
</form>
</body>
</html>
