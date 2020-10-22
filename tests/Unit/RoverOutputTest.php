<?php

namespace Tests\Unit;

use App\Models\Rover;
use PHPUnit\Framework\TestCase;

class RoverOutputTest extends TestCase
{
    /**
     * Rover 1 moving
     *
     * @return void
     */
    public function testMovingRover1()
    {
        $this->expectOutputString('1 3 N');

        print(
            (new Rover([
                Rover::START => '1 2 N',
                Rover::AREA => [Rover::X => 5, Rover::Y => 5],
                Rover::INSTRUCTIONS => 'LMLMLMLMM'
            ]))->runRover()
        );
    }

    /**
     * Rover 2 moving
     *
     * @return void
     */
    public function testMovingRover2()
    {
        $this->expectOutputString('5 1 E');

        print(
        (new Rover([
            Rover::START => '3 3 E',
            Rover::AREA => [Rover::X => 5, Rover::Y => 5],
            Rover::INSTRUCTIONS => 'MMRMMRMRRM'
        ]))->runRover()
        );
    }

}
