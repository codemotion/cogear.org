<a href="#" id="debug-link"><?=t('Dev info','Dev')?></a>
<div id="debug">
<?php echo t('<b>Generated in:</b> %.3f (second|seconds)','Dev',$data['time']); ?><br/>
<?php echo t('<b>Memory consumption:</b> %s','Dev',$data['memory']); ?>
<?=theme('debug')?>
</div>

