<?php if ($message = $this->session->flashdata('message')) : ?>
	<div class="alert alert-success" role="alert" style="margin-top: 10px;"><?php echo $message['message']; ?></div>
<?php endif; ?>