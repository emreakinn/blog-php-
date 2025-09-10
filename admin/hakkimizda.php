<?php require_once('header.php');

if (isset($_GET['hakkimizdaUpdateID'])) {
    $id = $_GET['hakkimizdaUpdateID'];

    $hakkimizdaGun = $db->prepare('SELECT * FROM hakkimizda WHERE id=?');
    $hakkimizdaGun->execute(array($id));
    $hakkimizdaGunFetch = $hakkimizdaGun->fetch();
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById("exampleModalHakkimizda"));
            myModal.show();
            });
        </script>';
}

?>
<!-- Hakkımızda Section Start -->
<div class="row">
    <div class="col-md-6">
        <h3>Hakkımızda Ayarları</h3>
    </div>
    <div class="col-md-6">
        <div class="text-end">
            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#staticBackdropHakkimizda">
                Ekle
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdropHakkimizda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ana Sayfa Hakkimizda Ayarları</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 text-center py-3">
                                        <div class="fs-3">Hakkimizda Ayarları</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="anabaslik" placeholder="Hakkımızda Ana Başlığı" class="form-control">
                                        <textarea name="baslik" id="baslik" placeholder="Hakkımızda Başlığı" rows="5" class="form-control my-2"></textarea>
                                        <textarea name="aciklama" id="aciklama" placeholder="Hakkımızda Açıklama" rows="5" class="form-control my-2"></textarea>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <label class="text-center">Hizmet Görseli Ekleyin
                                            <input type="file" name="gorsel" class="form-control" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <input type="submit" name="hakkimizdaKaydet" value="Kaydet" class="btn btn-success w-25">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        </div>
    </div>
</div>
<!-- Hakkımızda Section End -->

<div class="row">
    <div class="col-12">
        <div class="card shadow p-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $hakkimizda = $db->prepare('SELECT * FROM hakkimizda');
                        $hakkimizda->execute();
                        $hakkimizdaRow = $hakkimizda->fetch();
                        ?>
                        <h3><?php echo $hakkimizdaRow['anabaslik'] ?></h3>
                        <span class="fs-3"><?php echo $hakkimizdaRow['baslik'] ?></span>
                        <div class="my-3"><?php echo substr($hakkimizdaRow['aciklama'], 0, 600); ?></div>
                    </div>
                    <div class="col-md-6 my-auto text-end">
                        <img style="width: 60%; border-radius:32px;" src="<?php echo $hakkimizdaRow['gorsel']; ?>" alt="<?php echo $hakkimizdaRow['anabaslik'] ?>" class="w-50">
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center py-3">
                            <a href="hakkimizda.php?hakkimizdaUpdateID=<?php echo $hakkimizdaRow['id']; ?>"><button class="btn btn-warning w-25">Düzenle</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalHakkimizda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hakkımızda Ayarlarını Güncelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close"></button>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelector('#close').addEventListener('click', function() {
                            window.location.href = "hakkimizda.php";
                        });
                    });
                </script>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="anabaslikGun" value="<?php echo $hakkimizdaGunFetch['anabaslik']; ?>" class="form-control">
                            <textarea name="baslikGun" id="baslikGun" placeholder="Hakkımızda Başlık" rows="5" class="form-control my-2"><?php echo $hakkimizdaGunFetch['baslik']; ?></textarea>
                            <textarea name="aciklamaGun" id="aciklamaGun" placeholder="Hakkımızda Açıklama" rows="5" class="form-control my-2"><?php echo $hakkimizdaGunFetch['aciklama']; ?></textarea>
                        </div>
                        <div class="col-md-6 my-auto text-end">
                            <label><b>Mevcut Görsel</b> : <img src="<?php echo $hakkimizdaGunFetch['gorsel']; ?>" class="w-50" alt="<?php echo $hakkimizdaGunFetch['baslik']; ?>">
                                <input type="file" name="gorselGun" class="form-control">
                            </label>
                        </div>
                        <div class="text-center mt-3">
                            <input type="submit" name="hakkimizdaGuncelle" value="Güncelle" class="btn btn-success w-25">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal Kaydet -->
<?php
if (isset($_POST['hakkimizdaKaydet'])) {
    $hakkimizdaGorselKaydet = '../img/' . $_FILES['gorsel']['name'];

    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $hakkimizdaGorselKaydet)) {
        $hakkimizdaKaydet = $db->prepare('INSERT INTO hakkimizda(anabaslik,baslik,aciklama,gorsel) VALUES(?,?,?,?)');
        $hakkimizdaKaydet->execute(array($_POST['anabaslik'], $_POST['baslik'], $_POST['aciklama'], $hakkimizdaGorselKaydet));

        if ($hakkimizdaKaydet->rowCount()) {
            echo '<script>alert("Ayarlar Kayıt Edildi")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        } else {
            echo '<script>alert("Hata Oluştu")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        }
    }
}
?>
<!-- Modal Kaydet -->

<!-- Modal Güncelle -->
<?php
if (isset($_POST['hakkimizdaGuncelle'])) {
    $hakkimizdaGorselGuncel = '../img/' . $_FILES['gorselGun']['name'];

    if (move_uploaded_file($_FILES['gorselGun']['tmp_name'], $hakkimizdaGorselGuncel)) {
        $hakkimizdaGuncelle = $db->prepare('UPDATE hakkimizda SET anabaslik=?, baslik=?, aciklama=?, gorsel=? WHERE id=?');
        $hakkimizdaGuncelle->execute(array($_POST['anabaslikGun'], $_POST['baslikGun'], $_POST['aciklamaGun'], $hakkimizdaGorselGuncel, $id));
        if ($hakkimizdaGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        }
    } else {
        $hakkimizdaGuncelle = $db->prepare('UPDATE hakkimizda SET anabaslik=?, baslik=?, aciklama=? WHERE id=?');
        $hakkimizdaGuncelle->execute(array($_POST['anabaslikGun'], $_POST['baslikGun'], $_POST['aciklamaGun'], $id));
        if ($hakkimizdaGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=hakkimizda.php">';
        }
    }
}
?>
<!-- Modal Güncelle -->

<?php require_once('footer.php'); ?>