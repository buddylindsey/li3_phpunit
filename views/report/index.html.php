<div id="files">
<ul>
<?php foreach($files as $file): ?>
<li><a href="<?php echo substr_replace($file, '/test', 0, 5);  ?>"><?=$file ?></a></li>
<?php endforeach ?>
</ul>

</div>
<div id="results">
<ul>
<?php foreach($final['dd'] as $result): ?>
	<?php if($result['event'] === "test"): ?>
		<li>
		<?=$result['test']; ?> - <strong><?=$result['status']; ?></strong> - <em><?=$result['time']; ?></em>
		</li>
	<?php endif ?>
<?php endforeach ?>
</ul>
</div>