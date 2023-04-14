<?php

namespace APIVolunteerManagerIntegration\Helper;

class CacheBust {
	/**
	 * Returns the revved/cache-busted file name of an asset.
	 *
	 * @param string $name Asset name (array key) from rev-manifest.json
	 *
	 * @return string filename of the asset (including directory above)
	 */
	public function name( $name ): string {
		$jsonPath = API_VOLUNTEER_MANAGER_INTEGRATION_PATH . apply_filters(
				'APIVolunteerManagerIntegration/Helper/CacheBust/RevManifestPath',
				'dist/manifest.json'
			);

		$revManifest = [];
		if ( file_exists( $jsonPath ) ) {
			$revManifest = json_decode( file_get_contents( $jsonPath ), true );
		} elseif ( $this->isDebug() ) {
			echo '<div style="color:red">Error: Assets not built. Go to ' . API_VOLUNTEER_MANAGER_INTEGRATION_PATH . ' and run gulp. See ' . API_VOLUNTEER_MANAGER_INTEGRATION_PATH . 'README.md for more info.</div>';
		}

		if ( ! isset( $revManifest[ $name ] ) ) {
			return;
		}

		return $revManifest[ $name ];
	}

	/**
	 * Check if debug mode, Remove constant dependency in tests.
	 */
	public function isDebug(): bool {
		return defined( 'WP_DEBUG' ) && WP_DEBUG;
	}
}
