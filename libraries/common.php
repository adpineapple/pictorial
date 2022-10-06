<?php

function fn_common_generate_url($uri, $parameters = array())
{
    $port = empty($_SERVER['SERVER_PORT']) || in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : ':' . $_SERVER['SERVER_PORT'];
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';

    $url = sprintf("%s://%s%s", $protocol, $_SERVER['SERVER_NAME'] . $port, $uri);

    if(!empty($parameters) && is_array($parameters))
    {
    	foreach($parameters as $parameter => $value)
    	{
    		$parameters[$parameter] = urlencode($parameter) . '=' . urlencode($value);
    	}

    	$url .= '?' . implode('&', $parameters);
    }

    return $url;
}

?>