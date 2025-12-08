</body>
<script src="../assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.--btn-signup').on('click', function(e) {
            e.preventDefault();
            let email = $('#email').val();
            let password = $('#password').val();


            $.ajax({
                url: '../handlers/signup.php',
                method: "post",
                data: {
                    'signup': true,
                    'email': email,
                    'password': password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error)
                    } else {
                        alert(response.success)
                    }
                },
                error: function(xhr, response) {
                    console.log(xhr + response)
                }
            })
        })
    });
</script>

</html>