<?php require_once('header.php');

if (isset($_GET['hizmetUpdateID'])) {
    $id = $_GET['hizmetUpdateID'];

    $hizmetGun = $db->prepare('SELECT * FROM hizmetler WHERE id=?');
    $hizmetGun->execute(array($id));
    $hizmetGunFetch = $hizmetGun->fetch();
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById("exampleModalHizmet"));
            myModal.show();
            });
        </script>';
}
?>
<!-- Banner Section Start -->
<div class="row">
    <div class="col-md-6">
        <h3>Hizmet Ayarları</h3>
    </div>
    <div class="col-md-6">
        <div class="text-end">
            <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#staticBackdropBanner">
                Ekle
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdropBanner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ana Sayfa Hizmet Ayarları</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 text-center py-3">
                                        <div class="fs-3">Hizmet Ayarları</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="baslik" placeholder="Banner Başlığı Girin" class="form-control">
                                        <textarea name="aciklama" id="aciklama" placeholder="Banner Açıklama" rows="5" class="form-control my-2"></textarea>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <label class="text-center">Hizmet Görseli Ekleyin
                                            <input type="file" name="gorsel" class="form-control" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <input type="submit" name="bannerKaydet" value="Kaydet" class="btn btn-success w-25">
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
<!-- Banner Section End -->

<div class="row">
    <div class="col-12">
        <div class="card shadow p-3">
            <div class="card-body">
                <div class="row">
                    <?php
                    $hizmet = $db->prepare('SELECT * FROM hizmetler ORDER BY baslik ASC');
                    $hizmet->execute();
                    if ($hizmet->rowCount()) {
                        foreach ($hizmet as $hizmetRow) {
                    ?>
                            <div class="col-md-4">
                                <div class="card shadow">
                                    <img src="<?php echo $hizmetRow['gorsel']; ?>" alt="<?php echo $hizmetRow['baslik']; ?>">
                                    <div class="card-body">
                                        <h2><?php echo $hizmetRow['baslik']; ?></h2>
                                        <div class="my-3"><?php echo substr($hizmetRow['aciklama'], 0, 150) ?></div>
                                    </div>
                                    <div class="col-md-12 text-center py-3">
                                        <a href="hizmetler.php?hizmetUpdateID=<?php echo $hizmetRow['id']; ?>"><button class="btn btn-warning w-25">Düzenle</button></a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalHizmet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hizmet Ayarlarını Güncelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close"></button>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelector('#close').addEventListener('click', function() {
                            window.location.href = "hizmetler.php";
                        });
                    });
                </script>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <img src="<?php echo $hizmetGunFetch['gorsel']; ?>" class="w-100" alt="<?php echo $hizmetGunFetch['baslik']; ?>">
                                <input type="file" name="gorselGun" class="form-control">
                                <div class="card-body">
                                    <input type="text" name="baslikGun" value="<?php echo $hizmetGunFetch['baslik']; ?>" class="form-control">
                                    <textarea name="aciklamaGun" id="aciklamaGun" placeholder="Hizmet Açıklama" rows="5" class="form-control my-2"><?php echo $hizmetGunFetch['aciklama']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <input type="submit" name="hizmetGuncelle" value="Kaydet" class="btn btn-success w-25">
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal Kaydet -->
<?php
if (isset($_POST['hizmetKaydet'])) {
    $hizmetGorselKaydet = '../img/' . $_FILES['gorsel']['name'];

    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $hizmetGorselKaydet)) {
        $hizmetKaydet = $db->prepare('INSERT INTO hizmetler(baslik,aciklama,gorsel) VALUES(?,?,?)');
        $hizmetKaydet->execute(array($_POST['baslik'], $_POST['aciklama'], $hizmetGorselKaydet));

        if ($hizmetKaydet->rowCount()) {
            echo '<script>alert("Ayarlar Kayıt Edildi")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        } else {
            echo '<script>alert("Hata Oluştu")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        }
    }
}
?>
<!-- Modal Kaydet -->

<!-- Modal Güncelle -->
<?php
if (isset($_POST['hizmetGuncelle'])) {
    $hizmetGorselGuncel = '../img/' . $_FILES['gorselGun']['name'];

    if (move_uploaded_file($_FILES['gorselGun']['tmp_name'], $hizmetGorselGuncel)) {
        $hizmetGuncelle = $db->prepare('UPDATE hizmetler SET baslik=?, aciklama=?, gorsel=? WHERE id=?');
        $hizmetGuncelle->execute(array($_POST['baslikGun'], $_POST['aciklamaGun'], $hizmetGorselGuncel, $id));
        if ($hizmetGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        }
    } else {
        $hizmetGuncelle = $db->prepare('UPDATE hizmetler SET baslik=?, aciklama=? WHERE id=?');
        $hizmetGuncelle->execute(array($_POST['baslikGun'], $_POST['aciklamaGun'], $id));
        if ($hizmetGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=hizmetler.php">';
        }
    }
}
?>
<!-- Modal Güncelle -->

<?php require_once('footer.php'); ?>