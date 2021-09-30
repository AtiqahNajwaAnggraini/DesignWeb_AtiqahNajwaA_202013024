<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $NIM = isset($_POST['NIM']) && !empty($_POST['NIM']) && $_POST['NIM'] != '' ? $_POST['NIM'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $Nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
    $Umur = isset($_POST['Umur']) ? $_POST['Umur'] : '';
    $Prodi = isset($_POST['Prodi']) ? $_POST['Prodi'] : '';
    // $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO data VALUES (?, ?, ?, ?)');
    $stmt->execute([$NIM, $Nama, $Umur, $Prodi]);
    // Output message
    $msg = 'Berhasil Menambah Data!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="create.php" method="post">
        <div>
        <label for="NIM">NIM</label>
        <label for="Nama">Nama</label>
        <input type="text" name="NIM" value="" NIM="NIM">
        <input type="text" name="Nama" NIM="Nama">
        <label for="Umur">Umur</label>
        <label for="Prodi">Program Studi</label>
        <input type="number" name="Umur" value="<?=$contact['Umur']?>" NIM="Umur">
        
        <select name="Prodi" >
            <option value="">Pilih Prodi</option>
            <option value="Teknik Informatika">Teknik Informatika</option>
            <option value="Teknik Pengolahan Sawit">Teknik Pengolahan Sawit</option>
            <option value="Perawatan dan Perbaikan Mesin">Perawatan dan Perbaikan Mesin</option>
            <option value="Administrasi Bisnis Intenasional">Administrasi Bisnis Intenasional</option>
        </div>
        <!-- <input type="text" name="Umur" NIM="Umur">
        <input type="text" name="Prodi" NIM="Prodi"> -->
        <!-- <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" NIM="pekerjaan"> -->
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>