<?php

namespace Tests\Unit;

use App\Exceptions\InvalidRoverDataException;
use App\Models\Rover;
use PHPUnit\Framework\TestCase;

class RoverCreationTest extends TestCase
{
    /**
     * Rover creation from valid data
     *
     * @return void
     */
    public function testValidRoverData()
    {
        $this->assertInstanceOf(
            Rover::class,
            new Rover([
                Rover::START => '1 1 N',
                Rover::AREA => [Rover::X => 5, Rover::Y => 5],
                Rover::INSTRUCTIONS => 'LMLMLMLMLMMMMM'
            ])
        );
    }

    /**
     * Rover creation from invalid data
     *
     * @return void
     */
    public function testInvalidRoverData()
    {
        $this->expectException(InvalidRoverDataException::class);

        new Rover([
            Rover::START => '1 9 N',
            Rover::AREA => [Rover::X => 5, Rover::Y => 5],
            Rover::INSTRUCTIONS => 'LMLMLMLMLMMMMM'
        ]);
    }
}
