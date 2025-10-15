<?php
/**
 * @var array $news
 */
include_once RESOURCES . '/layout/header.php'
?>

    <div class="container p-3">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Последние новости</h2>
            </div>
        </div>

        <?php if ($news): ?>
            <div class="row text-center mt-5">
                <?php foreach ($news as $item): ?>
                    <div class="col-xl-6 col-md-12">
                        <div class="item border-1 mt-3">
                            <?php if ($img = $item['image'] ?? null): ?>
                                <img src="<?= $img ?>" alt="<?= $item['title'] ?>">
                            <?php endif; ?>
                            <h3><?= $item['title'] ?></h3>
                            <a href="<?=$item['link']?>" target="_blank">Перейти к новости</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <style>
        .item {
            max-width: 100%;
            border: 1px solid black;
            border-radius: 10px;
            padding: 0;
        }

        .item > img {
            max-width: 100%;
            border-radius: 9px;
        }
    </style>

<?php include_once RESOURCES . '/layout/footer.php' ?>