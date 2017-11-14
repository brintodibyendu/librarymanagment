<?php if(count($errors)>0): ?>
<?php foreach($errors as $error):?>
<div>
<?php echo "<p>{$error}</p> "?>
<?php endforeach?>
</div>
<?php endif ?>