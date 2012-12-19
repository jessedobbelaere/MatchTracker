<?php

namespace MatchTracker\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\Rest\Util\Codes;

/**
 * Users REST API controller
 *
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */
class UserRestController extends Controller {

	/**
	 * Get users
	 *
	 * @return mixed
	 */
	public function getUsersAction() {
		//$user = $this->get('security.context')->getToken()->getUser();
		$query = $this->getDoctrine()
			->getEntityManager()
			->createQueryBuilder('u')
			->select('u.id, u.username, u.usernameCanonical, u.firstname, u.lastname, u.facebookId, u.email, u.emailCanonical, u.lastLogin')
			->from('MatchTrackerAppBundle:Users', 'u')
			->getQuery();

		$users = $query->getResult();

		$view = View::create()
			->setStatusCode(Codes::HTTP_OK)
			->setData(array('users' => $users));

		return $this->get('fos_rest.view_handler')->handle($view);
	}

	/**
	 * Get the details of a user by id
	 *
	 * @param $id (int) user id
	 * @return mixed
	 */
	public function getUserAction($id) {
		//$user = $this->get('security.context')->getToken()->getUser();

		try {
			$id     = (int) $id;

			$query = $this->getDoctrine()
				->getEntityManager()
				->createQueryBuilder('u')
				->select('u.id, u.username, u.usernameCanonical, u.firstname, u.lastname, u.facebookId, u.email, u.emailCanonical, u.lastLogin')
				->from('MatchTrackerAppBundle:Users', 'u')
				->where('u.id = :id')
				->setParameter('id', $id)
				->getQuery();

			$user = $query->getResult();
			if(empty($user)) {
				throw new \Exception;
			}

			$view = View::create()
				->setStatusCode(Codes::HTTP_OK)
				->setData(array('user' => $user));
		} catch(\Exception $e) {
			$view = View::create()
				->setStatusCode(Codes::HTTP_NOT_FOUND)
				->setData('Error 404. This user doesn\'t exist');
		}

		return $this->get('fos_rest.view_handler')->handle($view);
	}
}
