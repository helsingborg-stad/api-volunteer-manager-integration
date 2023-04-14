<?php

// Public functions
if ( ! function_exists( 'apiVolunteerManagerIntegrationFakeJsonString' ) ) {
	function apiVolunteerManagerIntegrationFakeJsonString(): string {
		return '{
			  "posts": [
			    {
			      "id": 9485,
			      "title": "Assignment test",
			      "slug": "test",
			      "content": "Test content",
			      "type": "assignment"
			    },
			    {
			      "id": 475,
			      "title": "Assignment test 2",
			      "slug": "test-2",
			      "content": "Test content",
			      "type": "assignment"
			    },
			    {
			      "id": 2312,
			      "title": "Assignment test 3",
			      "slug": "test-3",
			      "content": "Test content",
			      "type": "assignment"
			    },
			    {
			      "id": 2312,
			      "title": "Assignment test 123",
			      "slug": "test-123",
			      "content": "Test content",
			      "type": "assignment"
			    }
			  ],
			  "terms": [],
			  "types": [
			    "assignment"
			  ],
			  "taxonomies": []
		}';
	}
}
