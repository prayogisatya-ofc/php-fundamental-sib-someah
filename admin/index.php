<?php 

$title = "Dashboard";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

?>

<!-- main -->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <?= $title ?>
                    </div>
                    <div class="card-body">
                        <h5>Selamat datang, <?= $_SESSION['username'] ?></h5>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam eos, aperiam quo aliquid sequi, ducimus modi dignissimos voluptatibus quas nobis laboriosam! Nostrum ab ipsum dicta iusto rem vitae nisi recusandae.
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "./layout/footer.php"; ?>