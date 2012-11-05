<?php

namespace MatchTracker\AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MatchTrackerAppBundle extends Bundle
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
