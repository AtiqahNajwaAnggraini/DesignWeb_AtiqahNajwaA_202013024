<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact NIM exists
if (isset($_GET['NIM'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM data WHERE NIM = ?');
    $stmt->execute([$_GET['NIM']]);
    $Nama = isset($_POST['Nama']) ? $_POST['Nama'] : '';
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that NIM!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM data WHERE NIM = ?');
            $stmt->execute([$_GET['NIM']]);
            $msg = 'Anda telah menghapus data';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Tidak ada NIM yang sesuai!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Hapus Data #<?=$contact['Nama']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Apa anda yakin menghapus data #<?=$contact['Nama']?>?</p>
    <div class="yesno">
        <a href="delete.php?NIM=<?=$contact['NIM']?>&confirm=yes">Yes</a>
        <a href="delete.php?NIM=<?=$contact['NIM']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>