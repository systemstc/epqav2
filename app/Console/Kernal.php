protected function schedule(Schedule $schedule)
{
    $schedule->command('app:renewal-dates')->daily();
}
