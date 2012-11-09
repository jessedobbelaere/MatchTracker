<?php

namespace MatchTracker\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MatchTrackerUserBundle extends Bundle
{
	/**
	 * Set FOSUserBundle as the parent, so we can override original login, registration, ... forms
	 *
	 * @return string
	 */
	public function getParent() {
		return 'FOSUserBundle';
	}
}
