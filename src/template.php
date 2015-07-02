<?php
/* @var $phpdoc phpDocumentor\Reflection\DocBlock */
?>
### <?= $name ?>

<?= $phpdoc->getShortDescription() ?>


```php
<?= $signature ?>

```
<?php foreach ($phpdoc->getTags() as $tag): ?>
<?php if ($tag->getName() == 'param'): ?>
<?php if (!isset($parametersShown)): ?>

*Parameters:*
<?php $parametersShown = true; ?>
<?php endif; ?>
- *<?= $tag->getType() ?>* <?= $tag->getVariableName() ?><?php if ($description = $tag->getDescription()): ?> - <?= $description ?><?php endif; ?>

<?php elseif ($tag->getName() == 'return'): ?>

*Returns:*
- *<?= $tag->getType() ?>*<?php if ($description = $tag->getDescription()): ?> - <?= $description ?><?php endif; ?>

<?php elseif ($tag->getName() == 'throws'): ?>
<?php if (!isset($throwsShown)): ?>

*Throws:*
<?php $throwsShown = true; ?>
<?php endif; ?>

- *<?= $tag->getType() ?>*<?php if ($description = $tag->getDescription()): ?> - <?= $description ?><?php endif; ?>

<?php endif; ?>
<?php endforeach; ?>

