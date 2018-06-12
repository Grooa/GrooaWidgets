<?php
$hasTransparentBackground = !empty($hasTransparentBackground) ? $hasTransparentBackground : false;
?>

<article class="gw-module gw-module-centered <?= !$hasTransparentBackground ? 'gw-module-light' : '' ?>">
    <h2 class="gw-title"><?= $title ?></h2>

    <?php if (!empty($headerText)): ?>
        <div class="gw-module-header">
            <?= $headerText ?>
        </div>
    <?php endif; ?>

    <div class="columns">
        <?php foreach ($items as $item): ?>
            <?php if($item['url']): ?>
                <a href="<?= $item['url'] ?>" class="image-module gw-module-item">
                    <section>
                        <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" class="gw-module-item-image">
                        <h3 class="gw-module-item-title"><?= $item['title'] ?></h3>
                    </section>
                </a>
            <?php else: ?>
                <section>
                    <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" class="gw-module-item-image">
                    <h3 class="gw-module-item-title"><?= $item['title'] ?></h3>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($footerText)): ?>
        <div class="gw-module-footer">
            <?= $footerText ?>
        </div>
    <?php endif; ?>
</article>
