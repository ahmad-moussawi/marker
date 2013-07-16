<ul class="breadcrumb">
	<li><a href="<?php echo site_url('admin') ?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?php echo site_url('admin/pages') ?>">Pages</a> <span class="divider">/</span></li>
	<li class="active"><?php echo $page->title ?></li>
</ul>


<dl class="dl-horizontal">
	<dt>Title</dt>
	<dd>
		<?php echo $page->title ?>
	</dd>

	<dt>Path</dt>
	<dd><?php echo $page->urlpath ?></dd>

	<dt>Body</dt>
	<dd><?php echo $page->body ?></dd>

	<dt>Created</dt>
	<dd><?php echo isset($page->created)?$page->created:'Undefined' ?></dd>

	<dt>Meta Keywords</dt>
	<dd><?php echo $page->meta ?></dd>

	<dt>Is Published ?</dt>
	<dd><input name="ispublished" disabled="disabled" <?php echo $page->ispublished?'checked="checked"':'' ?> type="checkbox"/></dd>
</dl>