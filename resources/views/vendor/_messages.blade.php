<?php
	$_messages_message = null;
	if(Session::has('message')) {
		$_messages_message = Session::get('message');
	}
?>
@if(!is_null($_messages_message))
	<div class="row">
		<div id="message">
			<div style="padding: 5px;">
				<div id="inner-message" class="alert alert-success text-center">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ $_messages_message }}
				</div>
			</div>
		</div>
	</div>
@endif
<?php
	$_messages_error = null;
	if(Session::has('error')) {
		$_messages_error = Session::get('error');
	}
?>
@if(!is_null($_messages_error))
	<div class="row">
		<div id="message">
			<div style="padding: 5px;">
				<div id="inner-message" class="alert alert-danger text-center">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ $_messages_error }}
				</div>
			</div>
		</div>
	</div>
@endif
<?php
	unset($_messages_message);
	unset($_messages_error);
?>
