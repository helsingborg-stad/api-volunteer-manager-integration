<?php

namespace APIVolunteerManagerIntegration\Services\WPService;

interface WPService extends
    WpGetNavMenuItems,
    GetNavMenuLocations,
    RegisterNavMenu,
    GetPostType,
    HomeUrl,
    IsArchive,
    IsSingle,
    RegisterRestRoute,
    WPNavService,
    WpEnqueueStyle,
    WpEnqueueScript
{
}
