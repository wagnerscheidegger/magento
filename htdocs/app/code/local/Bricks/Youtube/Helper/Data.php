<?php
class Bricks_Youtube_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getYoutubeSettings($key,$username)
    {
	    $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=".$username."&key=".$key;
		$curl = curl_init( $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_USERAGENT, '' );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );

		$response = curl_exec( $curl );
		if( 0 !== curl_errno( $curl ) || 200 !== curl_getinfo( $curl, CURLINFO_HTTP_CODE ) ) {
			$response = null;
		} // end if
		curl_close( $curl );

		// return $response;
		return json_decode($response);
	}
	public function getYoutubeVideos($key,$uploads,$pageToken)
    {
	   	$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$uploads."&order=date&maxResults=6&key=".$key."&pageToken=".$pageToken;
	   	$curl = curl_init( $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_USERAGENT, '' );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );

		$response = curl_exec( $curl );
		if( 0 !== curl_errno( $curl ) || 200 !== curl_getinfo( $curl, CURLINFO_HTTP_CODE ) ) {
			$response = null;
		} // end if
		curl_close( $curl );

		// return $response;
		$val = json_decode($response);
		// echo "<pre>";
		// print_r($val);exit;
		$array = array();
		$array['nextPageToken'] = $val->nextPageToken;
		$array['prevPageToken'] = $val->prevPageToken;
		foreach ($val as $key => $value) {
			if(is_array($value))
			{
				$array['items'] = $value;
			}else
			{
				$array['totalResults'] = $value->totalResults;
			}
		}
		return $array;

		// $videos_result = wp_remote_get( $video_feed_url );
		// $response_code = wp_remote_retrieve_response_code( $videos_result );
		// $rss = json_decode( $videos_result['body'] );
		// $entries = $rss;
	}
	public function getrecs($key,$uploads)
    {
		$JSON = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&channelID=UCU-DslmtYfEU1rI6X9bP4jA&key=AIzaSyBzKPC_GhcVNgB1nslE8LzuIFSgp5oIfpM");
        $JSON_Data = json_decode($JSON);
        $this->totalvideos = $JSON_Data->{'items'}->{'totalItems'};
        $this->videos_pages = floor($this->totalvideos/9);
        $this->enqueue_scripts();
        $this->video_feed_with_pagination(1);
  	}
}