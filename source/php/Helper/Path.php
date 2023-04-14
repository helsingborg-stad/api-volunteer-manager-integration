<?php

namespace APIVolunteerManagerIntegration\Helper;

class Path {

	public static function getLastPathItem( string $path ): string {
		$lastInPath = count( explode( '/', $path ) ) - 1;

		return explode( '/', $path )[ $lastInPath ] ?? '';
	}
}