<?php
    echo $this->Slug->include_script(array("inline"=>"true"));
?>
<div class="groups form span6 suffix_6">
<?php echo $this->Form->create('Group');?>
	<fieldset>
 		<legend><?php echo __('Translate Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->hidden('parent_id');
        echo $this->Form->input('Group.locale', array("type" => "select", 
                                                      "label" => __("Language"),
                                                      "options" => $locales));
		echo $this->Form->input('name', array("between" => $this->data["Translation"]["Group"]["name"]));
		echo $this->Form->input('description', array("type"=>"textarea", "between" => $this->data["Translation"]["Group"]["description"]));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions span6 suffix_6">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Group.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
	</ul>
</div>
<script type="text/javascript">
    $("#GroupName").focus();
</script>
<?php 
$this->Html->css("/urg/css/urg", null, array("inline"=>false));
