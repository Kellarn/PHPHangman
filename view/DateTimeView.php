<?php

namespace view;

class DateTimeView {

	/**
	 * Function to return the current date and time
     * 
	 * Is called for every new render of the page.
	 *
	 * @return string message to display if the user could be found or not or if anything else happend.
	 */

	public function show() {
		date_default_timezone_set("Europe/Stockholm");
		$timeString = date("l") . ", the " . date("dS") . " of " . date("F Y") . ", The time is " . date("H:i:s");

		return '<p>' . $timeString . '</p>';
	}
}