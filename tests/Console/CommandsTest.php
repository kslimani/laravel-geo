<?php

namespace Tests\Console;

use Tests\TestCase;

/**
 * Only make sure that the commands can be executed
 */
class CommandsTest extends TestCase
{
    public function test_it_run_geo_exchange_command()
    {
        $this->artisan('geo:exchange EUR RON')->assertExitCode(0);
    }

    public function test_it_run_geo_info_command()
    {
        $this->artisan('geo:info 8.8.8.8')->assertExitCode(0);
    }

    public function test_it_run_geo_list_command()
    {
        $this->artisan('geo:list')->assertExitCode(0);
    }

    public function test_it_run_geo_maxmind_command()
    {
        $this->artisan('geo:maxmind -h')->assertExitCode(0);
    }
}
