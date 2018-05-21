<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

// Place here all of your cron jobs

// This command will execute ls command every five minutes
// $schedule->exec('ls')->everyFiveMinutes();

// This command will execute migration command of your application every hour
// $schedule->command('migrate')->hourly();

// This command will call callback function every day at 10:00
$schedule->call(function(\yii\console\Application $app) {
    return true;
})->dailyAt('15:27');