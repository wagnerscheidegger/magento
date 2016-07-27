<?php
class Netsol_SocialDiscount_TwitterController extends Mage_Core_Controller_Front_Action
{
	public function postFeedAction() {
		$productId = $this->getRequest()->getPost('productId');
		if(!$productId) {
			return false;
		}
		
		$twitter = new TwitterAPIExchange(array(
			'oauth_access_token' => Mage::getStoreConfig('netsol_sd/sd_twitter/twitter_access_token'),
			'oauth_access_token_secret' => Mage::getStoreConfig('netsol_sd/sd_twitter/twitter_access_token_secret'),
			'consumer_key' => Mage::getStoreConfig('netsol_sd/sd_twitter/twitter_consumer_key'),
			'consumer_secret' => Mage::getStoreConfig('netsol_sd/sd_twitter/twitter_consumer_secret')
		));
		
		/* $getParameters = array(
			'screen_name=' . urlencode('shikhasingla78'),
			'count=' . urlencode(5)
		); 
		$responseJson = $twitter->setGetfield('?'.implode('&', $getParameters))
								->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET')
								->performRequest(); */
		
		$product = Mage::getModel('catalog/product')->load($productId);
		
		//upload product images as twitter media
		$media_data = base64_encode(file_get_contents(Mage::helper('catalog/image')->init($product, 'thumbnail')));
		$postParams = array('media' => $media_data, 'media_data' => $media_data);						
		$responseJson = $twitter->setPostfields($postParams)
								->buildOauth('https://upload.twitter.com/1.1/media/upload.json', 'POST')
								->performRequest();
		$mediaResponse = Mage::helper('core')->jsonDecode($responseJson);
		
		//post tweet on twitter     
		$postParams = array('status' => $product->getName());
		
		/* check if image was uploaded */
		if(isset($mediaResponse['media_id_string']) && $mediaResponse['media_id_string'] != '') {
			$postParams['media_ids'] = $mediaResponse['media_id_string'];
		}
		
		$responseJson = $twitter->setPostfields($postParams)
								->buildOauth('https://api.twitter.com/1.1/statuses/update.json', 'POST')
								->performRequest();
		$postResponse = Mage::helper('core')->jsonDecode($responseJson);
		
		//return response
		$response = array();
		if(isset($postResponse['id']) && $postResponse['id'] != '') {
			$response['success'] = true;
			$response['post_id'] = $postResponse['id_str'];
		}
		
		$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(json_encode($response));
	}
}
