<?php

function fn_session_set_notification($type, $text)
{
	$supported = array('success', 'info', 'warning', 'error');

	if(empty($type) || !in_array($type, $supported) || empty($text))
	{
		return;
	}

	$_SESSION['notifications'][] = array(
		'type' => $type,
		'text' => htmlentities($text, ENT_QUOTES | ENT_HTML5)
	);

	return;
}

function fn_session_retrieve_notifications($clear = false)
{
	$notifications = empty($_SESSION['notifications']) ? array() : $_SESSION['notifications'];

	if($clear)
	{
		fn_session_clear_notifications();
	}

	return $notifications;
}

function fn_session_clear_notifications()
{
	$_SESSION['notifications'] = array();

	return;
}

?>