<?php
	echo '<h1 style="color: cornflowerblue">wccpf-admin-input-fields.php</h1>';
	
function display_form_meat()
{
    //id and name of form element should be same as the setting name.
    ?>
        <input type="text" name="wccpf_form_field_meat" id="wccpf_form_field_meat" value="<?php echo esc_attr(get_option('wccpf_form_field_meat')); ?>" />
    <?php
}

function display_ham_fields($hamFieldCount)
{	
    //id and name of form element should be same as the setting name.	
	$hamFormFieldName = 'ham_form_field_'.$hamFieldCount;
	?>
	<!-- <p>$numOfFields: <?php echo $numOfFields; ?></p> -->
    	<input type="text" name='<?php echo $hamFormFieldName; ?>' id='<?php echo $hamFormFieldName; ?>' value='<?php echo esc_attr(get_option($hamFormFieldName)); ?>' />
	<?php	
		
}