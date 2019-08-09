<?php
namespace ZFlex\Framework;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
use Exception;

class Framework extends AbstractPlugin
{


	public function __construct()
	{
	}

	public function getEventManager()
	{
		return \Factory\EventManagerFactory::getEventManager();
	}

	public function getServiceLocator()
	{
		return \Factory\ServiceLocatorFactory::getServiceLocator();
	}

	public function getEM()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	public static function getIP()
    {
        $json = file_get_contents('https://freegeoip.net/json/');
        $obj = json_decode($json);
        return $obj;
    }

	public function Facebook()
	{
		if (!session_id()) {
		    session_start();
		}
		$fb_config = $this->getServiceLocator()->get('config')['facebook'];
		$fb = new \Facebook\Facebook([
		  'app_id' => $fb_config['app_id'], // Replace {app-id} with your app id
		  'app_secret' => $fb_config['app_secret'],
		  'default_graph_version' => $fb_config['default_graph_version'],
		]);
		return $fb;
	}

	public function URLLoginFacebook()
	{
		$fb = $this->Facebook();
		$helper = $fb->getRedirectLoginHelper();
		$_SESSION['FBRLH_state']=$_GET['state'];
		$permissions = ['public_profile','email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl(PATH + 'login.html', $permissions);
		return $loginUrl;
	}

	public function CallbackLoginFacebook()
	{
		$fb = $this->Facebook();
		$fb_config = $this->getServiceLocator()->get('config')['facebook'];
		$helper = $fb->getRedirectLoginHelper();
		$_SESSION['FBRLH_state']=$_GET['state'];

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
		    header('HTTP/1.0 401 Unauthorized');
		  } else {
		    header('HTTP/1.0 400 Bad Request');
		  }
		  exit;
		}

		// Logged in
		$accessToken->getValue();

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		
		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId($fb_config['app_id']); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
		    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
		    exit;
		  }

		  $accessToken->getValue();
		}
		$_SESSION['fb_access_token'] = (string) $accessToken;
		$response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
        $user = $response->getGraphUser();
        $em = $this->getEM();
        $qb = $em->createQueryBuilder();
        $customer = $qb->select('count(customer)')->where('customer.fb_id = '.$user['id'])->from('ZFlex\Entity\Customer','customer');
        $count = $customer->getQuery()->getSingleScalarResult();
        $redirect = $this->getServiceLocator()->get('ControllerPluginManager')->get('redirect');
        $link = $this->getServiceLocator()->get('ViewHelperManager')->get('url')->__invoke('home');
		if($count == 0)
		{
			$customer = new \ZFlex\Entity\Customer;
			$customer->setFbId($user['id']);
			$customer->setFbName($user['name']);
			$customer->setIsBlock(0);
			$customer->setMoney('0');
			$customer->setOpenShop(0);
			$customer->setTimeCreated(\Carbon\Carbon::now());
			$em->persist($customer);
			$em->flush();
		}
		else{
			$result_customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $user['id']));
			if($result_customer->getIsBlock() == 1)
			{
				$banned = $em->getRepository('ZFlex\Entity\Banned')->findOneBy(array('customer' => $result_customer),array('id' => 'DESC'));
				$_SESSION['fb_access_token'] = '';
				$block = new Container('block');
				$block->block = '<h3>Bạn đã bị khóa tài khoản vì lý do : '.$banned->getReason().'</br>Mọi thắc mắc hãy liên hệ admin .</br> Ấn vào <a href="'.$link.'">đây</a> để quay lại trang chủ !</h3>';
				return $redirect->toRoute('notification');
				die;
			}else{
				if($result_customer->getFbName() != $user['name'])
				{
					$result_customer->setFbName($user['name']);
					$em->persist($result_customer);
					$em->flush();
				}
			}
		}
		
		$fb_info = new Container('fb_info');
		$fb_info->id = $user['id'];
		$fb_info->name = $user['name'];
		// User is logged in with a long-lived access token.
		// You can redirect them to a members-only page.
		return $redirect->toRoute('home');
	}

	public function FacebookInfo($key = '')
	{
		$session = new Container('fb_info');
		if($session->offsetExists('id'))
		{
			$result = $session;
			if($key == '')
			{
				$_result = $result;
			}
			else
			{
				$_result = $result->$key;
			}
		}else{
			$_result = '';
		}
		
		return $_result;

	}

}