<?php

namespace Modules\Ccc\Entities;

use Modules\ProvBase\Entities\Contract;

class CccContract extends Contract {

	// SQL connection
	// This is a security plus to let the CCC sql user only have read-only access to the required tables
	protected $connection = 'mysql-ccc';

}
