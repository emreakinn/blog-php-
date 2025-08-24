<?php require_once('header.php');

if (isset($_GET['bannerUpdateID'])) {
    $id = $_GET['bannerUpdateID'];

    $bannerGun = $db->prepare('SELECT * FROM banner WHERE id=?');
    $bannerGun->execute(array($id));
    $bannerGunFetch = $bannerGun->fetch();
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById("exampleModalBanner"));
            myModal.show();
            });
        </script>';
}

?>
<!-- Banner Section Start -->
<div class="row py-3">
    <div class="col-md-6">
        <h3>Banner Ayarları</h3>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ana Sayfa Banner Ayarları</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 text-center py-3">
                                        <div class="fs-3">Banner Ayarları</div>
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

<div class="card shadow py-3">
    <div class="card-body">
        <div class="row px-5">
            <?php
            $banner = $db->prepare('SELECT * FROM banner ORDER BY id DESC');
            $banner->execute();
            if ($banner->rowCount()) {
                foreach ($banner as $bannerRow) {
            ?>
                    <div class="col-md-6 my-auto">
                        <h1><?php echo $bannerRow['baslik'] ?></h1>
                        <p><?php echo $bannerRow['aciklama'] ?></p>
                    </div>
                    <div class="col-md-6 my-auto text-end">
                        <img style="width: 60%; border-radius:32px;" src="<?php echo $bannerRow['gorsel'] ?>" alt="" class="w-50">
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center py-3">
                            <a href="banner.php?bannerUpdateID=<?php echo $bannerRow['id']; ?>"><button class="btn btn-warning w-25">Düzenle</button></a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Banner Ayarlarını Güncelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close"></button>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelector('#close').addEventListener('click', function() {
                            window.location.href = "banner.php";
                        });
                    });
                </script>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="fs-3">Banner Ayarlarını Güncelle</div>
                    <div class="row">
                        <div class="col-md-6 my-auto text-start">
                            <input type="text" name="baslikGun" value="<?php echo $bannerGunFetch['baslik']; ?>" class="form-control">
                            <textarea name="aciklamaGun" id="aciklamaGun" placeholder="Banner Açıklama" rows="5" class="form-control my-2"><?php echo $bannerGunFetch['aciklama']; ?></textarea>
                        </div>
                        <div class="col-md-6 my-auto text-end">
                            <label><b>Mevcut Görsel</b> : <img src="<?php echo $bannerGunFetch['gorsel']; ?>" class="w-50" alt="<?php echo $bannerGunFetch['baslik']; ?>">
                                <input type="file" name="gorselGun" class="form-control">
                            </label>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <input type="submit" name="bannerGuncelle" value="Güncelle" class="btn btn-success w-25">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal Kaydet -->
<?php
if (isset($_POST['bannerKaydet'])) {
    $bannerGorselKaydet = '../img/' . $_FILES['gorsel']['name'];

    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $bannerGorselKaydet)) {
        $bannerKaydet = $db->prepare('INSERT INTO banner(baslik,aciklama,gorsel) VALUES(?,?,?)');
        $bannerKaydet->execute(array($_POST['baslik'], $_POST['aciklama'], $bannerGorselKaydet));

        if ($bannerKaydet->rowCount()) {
            echo '<script>alert("Ayarlar Kayıt Edildi")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        } else {
            echo '<script>alert("Hata Oluştu")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        }
    }
}
?>
<!-- Modal Kaydet -->

<!-- Modal Güncelle -->
<?php
if (isset($_POST['bannerGuncelle'])) {
    $bannerGorselGuncel = '../img/' . $_FILES['gorselGun']['name'];

    if (move_uploaded_file($_FILES['gorselGun']['tmp_name'], $bannerGorselGuncel)) {
        $bannerGuncelle = $db->prepare('UPDATE banner SET baslik=?, aciklama=?, gorsel=? WHERE id=?');
        $bannerGuncelle->execute(array($_POST['baslikGun'], $_POST['aciklamaGun'], $bannerGorselGuncel, $id));
        if ($bannerGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        }
    } else {
        $bannerGuncelle = $db->prepare('UPDATE banner SET baslik=?, aciklama=? WHERE id=?');
        $bannerGuncelle->execute(array($_POST['baslikGun'], $_POST['aciklamaGun'], $id));
        if ($bannerGuncelle->rowCount()) {
            echo '<script>alert("Ayarlar Güncellendi")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        } else {
            echo '<script>alert("Hata Alındı")</script><meta http-equiv="refresh" content="0; url=banner.php">';
        }
    }
}
?>
<!-- Modal Güncelle -->

<?php require_once('footer.php'); ?>