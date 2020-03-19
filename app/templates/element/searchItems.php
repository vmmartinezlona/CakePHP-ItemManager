<?= $this->Form->create('Post', array('action' => 'search')); ?>
	<?= $this->Form->input('searchtag', array('label' => '', 'placeholder' => 'Search By tag...')); ?>
<?= $this->Form->end(); ?>