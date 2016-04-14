<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;

/**
 * Base class for jobs
 *
 * This job base class provides a central location to place any logic that
 * is shared across all of your jobs. The trait included with the class
 * provides access to the "onQueue" and "delay" queue helper methods.
 */
abstract class Job {

	use Queueable;
}
