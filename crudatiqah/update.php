<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact NIM exists, for example update.php?NIM=1 will get the contact with the NIM of 1
if (isset($_GET['NIM'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $NIM = isset($_POST['NIM']) ? $_POST['NIM'] : NULL;
        $Nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
        $Umur = isset($_POST['Umur']) ? $_POST['Umur'] : '';
        $Prodi = isset($_POST['Prodi']) ? $_POST['Prodi'] : '';
                // $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE data SET NIM = ?, Nama = ?, Umur = ?, Prodi = ? WHERE NIM = ?');
        $stmt->execute([$NIM, $Nama, $Umur, $Prodi, $_GET['NIM']]);
        $msg = 'Update Berhasil!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM data WHERE NIM = ?');
    $stmt->execute([$_GET['NIM']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Tidak ditemukan NIM yang sesuai!');
    }
} else {
    exit('No NIM specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Data #<?=$contact['Nama']?></h2>
    <form action="update.php?NIM=<?=$contact['NIM']?>" method="post">
        <div>
        <label for="NIM">NIM</label>
        <label for="Nama">Nama</label>
        <input type="text" name="NIM" value="<?=$contact['NIM']?>" NIM="NIM">
        <input type="text" name="Nama" value="<?=$contact['Nama']?>" NIM="Nama">
        <label for="Umur">Umur</label>
        <label for="Prodi">Prodi</label>
        <input type="number" name="Umur" value="<?=$contact['Umur']?>" NIM="Umur">
        <select name="Prodi">
                        <option value="">Pilih Prodi</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Teknik Pengolahan Sawit">Teknik Pengolahan Sawit</option>
                        <option value="Perawatan dan Perbaikan Mesin">Perawatan dan Perbaikan Mesin</option>
                        <option value="Administrasi Bisnis Intenasional">Administrasi Bisnis Intenasional</option>
        </div>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>