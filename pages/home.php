<?php include('../includes/header.php'); ?>
<body>

<dialog id="signupModal" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Sign up!</h3>
        <form id="signupForm">
            <input type="email" name="email" id="email" placeholder="Your Email" class="input input-ghost w-full" required />
            <input type="password" name="password" id="password" placeholder="Your Password" class="input input-ghost w-full mt-2" required />

            <div id="signupMessage" style="color:red; margin:10px 0;"></div>

            <button type="submit" class="btn btn-primary mt-2">Signup</button>
            <button type="button" class="btn ml-2" onclick="signupModal.close()">Close</button>
        </form>
    </div>
</dialog>

<div class="relative w-full h-72 mt-4">

    <div class="carousel w-full h-full">
        <div id="item1" class="carousel-item w-full">
            <img src="../assets/photo1.jpg" class="w-full h-full object-cover" />
        </div>

        <div id="item2" class="carousel-item w-full">
            <img src="../assets/photo2.jpg" class="w-full h-full object-cover" />
        </div>

        <div id="item3" class="carousel-item w-full">
            <img src="../assets/photo3.jpg" class="w-full h-full object-cover" />
        </div>

        <div id="item4" class="carousel-item w-full">
            <img src="../assets/photo4.jpg" class="w-full h-full object-cover" />
        </div>
    </div>

    <div class="absolute inset-0 flex flex-col items-center justify-center text-white bg-black/40">
        
        <h1 class="text-4xl font-bold mb-4">Hotel Reservation System</h1>

        <div class="flex gap-3">
            <button class="btn" onclick="signupModal.showModal()">Sign up</button>
            <a href="login.php" class="btn">Login</a>
        </div>
    </div>

</div>



<div class="flex w-full justify-center gap-2 py-2">
    <a href="#item1" class="btn btn-xs">1</a>
    <a href="#item2" class="btn btn-xs">2</a>
    <a href="#item3" class="btn btn-xs">3</a>
    <a href="#item4" class="btn btn-xs">4</a>
</div>

<center><h1 class="text-4xl font-bold mt-10">Rooms Available</h1></center>

<?php
$roomImages = [
    "../assets/image.jpg",
    "../assets/image1.jpg",
    "../assets/image2 (2).jpg",
    "../assets/image3.jpg",
    "../assets/image4.jpg"
];

$roomTitles = [
    "Deluxe Room",
    "Executive Suite",
    "Standard Room",
    "Family Room",
    "Presidential Suite"
];
?>

<div class="flex flex-wrap gap-5 justify-center py-5">
    <?php 
    $descriptions = [
        "Spacious room with king-size bed and modern amenities.",
        "A luxury suite with an amazing ocean view.",
        "Affordable room with queen-size bed.",
        "Perfect for families, with 2 beds and a living area.",
        "Perfect for families, with 2 beds and a living area."
    ];
    ?>
    
    <?php for ($i = 0; $i < count($roomImages); $i++): ?>
        <div class="card bg-base-100 w-96 shadow-sm">
            <figure>
                <img src="<?= $roomImages[$i] ?>" class="w-full h-56 object-cover" alt="Room">
            </figure>
            
            <div class="card-body">
                <h2 class="card-title"><?= $roomTitles[$i] ?></h2>
                <p><?= $descriptions[$i % count($descriptions)] ?></p>
            </div>
        </div>
    <?php endfor; ?>
</div>



<script>
document.addEventListener("DOMContentLoaded", () => {
    const signupForm = document.getElementById("signupForm");
    const signupMsg = document.getElementById("signupMessage");

    signupForm.addEventListener("submit", e => {
        e.preventDefault();
        const formData = new FormData(signupForm);
        formData.append("signup", true);

        fetch("../handlers/signup.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                signupMsg.style.color = data.success ? "green" : "red";
                signupMsg.textContent = data.success || data.error;
                if (data.success) signupForm.reset();
            })
            .catch(err => {
                signupMsg.style.color = "red";
                signupMsg.textContent = "An error occurred: " + err;
            });
    });
});
</script>

<?php include('../includes/footer.php'); ?>
</body>
