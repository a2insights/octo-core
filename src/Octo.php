<?php

namespace Octo;

class Octo
{
    /**
     * Determine if the application using any notifications features.
     *
     * @return bool
     */
    public static function hasNotificationsFeatures()
    {
        return Features::hasNotificationsFeatures();
    }

    /**
     * Determine if the billing portal is enabled.
     *
     * @return bool
     */
    public static function hasBillingDashboardFeatures()
    {
        return Features::hasBillingDashboardFeatures();
    }

    /**
     * Determine if the billing portal is enabled.
     *
     * @return bool
     */
    public static function hasWelcomeUserFeatures()
    {
        return Features::hasWelcomeUserFeatures();
    }
}
