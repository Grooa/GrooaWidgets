<?php
$hasTransparentBackground = !empty($hasTransparentBackground) ? $hasTransparentBackground : false;
?>

<article class="gw-module gw-module-centered <?= $hasTransparentBackground ? 'gw-module-light' : '' ?>">
    <h2 class="gw-title"><?= $title ?></h2>

    <?php if (!empty($subTitle)): ?>
        <strong class="gw-subtitle"><?= $subTitle ?></strong>
    <?php endif; ?>

    <div class="gw-module-list-wrapper">
        <ul class="gw-module-list">
            <?php foreach ($items as $key => $item): ?>
                <li>
                    <div class="columns">
                        <div class="gw-module-list-thumbnail">
                            <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>">
                        </div>
                        <div class="gw-module-list-body">
                            <h3><?= $item['id'] ?>. <?= $item['title'] ?></h3>

                            <div>
                                <?= $item['body'] ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</article>
