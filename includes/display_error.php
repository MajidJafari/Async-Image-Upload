<?php
//include ('config_error_display.php');


// Flag variable for site status
define('LIVE', FALSE);
include __DIR__.'/config_error_display.php';
// Create the error handler function
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
	
	// Build the error message
	$message = "An error occurred in script '$e_file' on $e_line: $e_message\n";
	
	// Add $e_vars to message
	$message .= print_r($e_vars, 1);
	
	// Log the error for security and maintenance analyzing
	//error_log($message, 3 /*write the error in text file*/, 'errorsLog.txt');
	
	if(!LIVE) {
		echo '<pre><div id="message">'. $message ."\n";
		echo '<style>
				#message {
					overflow: visible;
					/*color: #fff3cd;*/
					width: 800px;
					text-align: left;
				
				}
			</style>';
		debug_print_backtrace();
		echo '</div></pre><br>';
	}
	/*elseif($e_number != E_NOTICE) {
		echo '<div class="error">
		A system error occurred.
		We apologize for inconvenience.</div><br>';
	}*/
}// End of my_error_handler function definition

// Set my error handler
set_error_handler('my_error_handler');

// Create errors

// Set simple text for specific error
/*if($var % 2 == 0) {
	trigger_error('Something bad happened');
}*/