<?php require_once('header.php') ?>
<section id="mainBanner">
    <div class="container py-5">
        <div class="card shadow py-80">
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
                                <img src="<?php echo substr($bannerRow['gorsel'], 1); ?>" alt="" class="w-50">
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="hizmetler">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <?php
                    $hizmetler = $db->prepare('SELECT * FROM hizmetler ORDER BY baslik ASC');
                    $hizmetler->execute();
                    if ($hizmetler->rowCount()) {
                        foreach ($hizmetler as $hizmetlerRow) {
                    ?>
                            <div class="col-md-4">
                                <div class="card shadow">
                                    <img src="<?php echo substr($hizmetlerRow['gorsel'], 1); ?>" alt="<?php echo $hizmetlerRow['baslik']; ?>">
                                    <div class="card-body">
                                        <h2><?php echo $hizmetlerRow['baslik']; ?></h2>
                                        <div class="my-3"><?php echo substr($hizmetlerRow['aciklama'], 0, 150) ?></div>
                                        <a href="hizmetler.php?id=<?php echo $hizmetlerRow['id']; ?>" class="btn btn-primary">Daha Fazla Bilgi</a>
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
</section>
<section id="hakkimizda">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $hakkimizda = $db->prepare('SELECT * FROM hakkimizda');
                        $hakkimizda->execute();
                        $hakkimizdaRow = $hakkimizda->fetch();
                        ?>
                        <h3><?php echo $hakkimizdaRow['anabaslik'] ?></h3>
                        <span class="fs-3">En İyi 360 Derece Dijital Ajans</span>
                        <div class="my-3"><?php echo substr($hakkimizdaRow['aciklama'], 0, 600); ?></div>
                    </div>
                    <div class="col-md-6 my-auto text-end">
                        <img src="<?php echo $hakkimizdaRow['gorsel']; ?>" alt="<?php echo $hakkimizdaRow['anabaslik'] ?>" class="w-50">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="paketler">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        Paketler
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="guncelBlog">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-body">
                <div class="col-md-4">
                    Güncel Bloglar
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php') ?>