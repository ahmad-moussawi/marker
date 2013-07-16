<ul class="breadcrumb">
	<li><a href="<?php echo site_url('admin') ?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?php echo site_url('admin/pages') ?>">Pages</a> <span class="divider">/</span></li>
	<li class="active">New Page</li>
</ul>

<?php echo validation_errors() ?>


<?php echo form_open('admin/pages/create' ,'class="validate"') ?>
	<legend data-live="[name=title]" data-tmpl="Create &raquo; %">New Page</legend>
	

	<label>Title</label>
	<?php echo form_input('title', set_value('title'), 'placeholder="Page title &hellip;" class="required"') ?>

	<label>Path</label>
	<?php echo form_input('urlpath', set_value('urlpath'), 'class="required" data-filter="[name=title] | url"') ?>

	<label>Body</label>
	<?php echo form_textarea('body', set_value('body'), 'data-editor="true" placeholder="Enter the page content here"') ?>
	<p class="help-block">Enter the page content here</p>

	<label>Created</label>
	<?php echo form_input('created', set_value('created'), 'placeholder="' . date('Y-m-d H:i:s') . '"') ?>

	<label>Meta Keywords</label>
	<?php echo form_input('meta', set_value('title'), 'placeholder="Page Meta"') ?>
	<span class="help-block">Enter the meta keywords here.</span>

	<label class="checkbox">
		<input name="ispublished" checked="checked" type="checkbox">Is Published ?
	</label>

	<input type="submit" class="btn btn-primary" value="Create" />

<?php echo form_close() ?>

