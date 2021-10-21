<?php

namespace Octo;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('octo.features', []));
    }

    /**
     * Determine if the feature is enabled and has a given option enabled.
     *
     * @param  string  $feature
     * @param  string  $option
     * @return bool
     */
    public static function optionEnabled(string $feature, string $option)
    {
        return static::enabled($feature) &&
               config("octo-options.{$feature}.{$option}") === true;
    }

    /**
     * Determine if the application using any notifications features.
     *
     * @return bool
     */
    public static function hasNotificationsFeatures()
    {
        return static::enabled(static::notifications());
    }

    /**
     * Determine if the application using any welcome user features.
     *
     * @return bool
     */
    public static function hasWelcomeUserFeatures()
    {
        return static::enabled(static::welcomeUserNotifications());
    }

    /**
     * Enable the notifications feature.
     *
     * @param  array  $options
     * @return string
     */
    public static function notifications(array $options = [])
    {
        if (! empty($options)) {
            config(['octo-options.notifications' => $options]);
        }

        return 'notifications';
    }

    /**
     * Enable the welcome user notifications feature.
     *
     * @param  array  $options
     * @return string
     */
    public static function welcomeUserNotifications(array $options = [])
    {
        if (! empty($options)) {
            config(['octo-options.welcome-user-notifications' => $options]);
        }

        return 'welcome-user-notifications';
    }

    /**
     * Enable the billing dashboard.
     *
     * @return string
     */
    public static function billingDasboard()
    {
        return 'billing-dashboard';
    }

    /**
     * Determine if the pusher provider is active.
     *
     * @return bool
     */
    public static function sendsPusherNotifications()
    {
        return static::optionEnabled(static::notifications(), 'pusher');
    }

    /**
     * Determine if the welcome user queue feature is active.
     *
     * @return bool
     */
    public static function queuedWelcomeUserNotifications()
    {
        return static::optionEnabled(static::welcomeUserNotifications(), 'queued');
    }

    /**
     * Determine if the billing portal is enabled.
     *
     * @return bool
     */
    public static function hasBillingDashboardFeatures()
    {
        return static::enabled(static::billingDasboard());
    }
}
