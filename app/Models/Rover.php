<?php

namespace App\Models;

use App\Exceptions\InvalidRoverDataException;

class Rover
{
    const X = 'x';
    const Y = 'y';
    const AREA = 'area';
    const START = 'start';
    const INSTRUCTIONS = 'instructions';
    const FACING = ['N', 'W', 'S', 'E'];

    /**
     * The position of the rover.
     *
     * @var array
     */
    protected $position = [
        self::X => null,
        self::Y => null
    ];

    /**
     * The area for rover to move on
     *
     * @var array
     */
    protected $area = [
        self::X => null,
        self::Y => null
    ];

    /**
     * The current direction rover is facing.
     *
     * @var string
     */
    protected $facing = null;

    /**
     * The commands for rover to process.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Rover constructor - using area and rover data from input
     *
     * @param array $initialData initial data for area and rover from input
     * @throws InvalidRoverDataException invalid data given for rover
     */
    public function __construct(array $initialData)
    {
        $start = explode(" ", $initialData[self::START]);
        $this->position[self::X] = array_shift($start);
        $this->position[self::Y] = array_shift($start);
        $this->area[self::X] = array_shift($initialData[self::AREA]);
        $this->area[self::Y] = array_shift($initialData[self::AREA]);
        $this->facing = array_shift($start);
        $this->commands = str_split($initialData[self::INSTRUCTIONS]);
        if (!is_numeric($this->position[self::X]) || !is_numeric($this->position[self::Y])
            || array_search($this->facing, self::FACING) === false
            || $this->position[self::X]>$this->area[self::X]|| $this->position[self::Y]>$this->area[self::Y]
            || $this->position[self::X]<0 || $this->position[self::Y]<0)
            throw new InvalidRoverDataException();
    }

    /**
     * Process rover commands and return rover status
     *
     * @return string
     */
    public function runRover()
    {
        while ($command = array_shift($this->commands)) {
            $this->processCommand($command);
        }
        return $this->status();
    }

    /**
     * Returns rover status
     *
     * @return string
     */
    public function status()
    {
        return implode(" ", $this->position) . " " . $this->facing;
    }

    /**
     * Process given command for rover
     *
     * @param $command
     */
    private function processCommand($command)
    {
        switch ($command) {
            case 'M':
                $this->move();
                break;
            case 'R':
                $this->rotateRight();
                break;
            case 'L':
                $this->rotateLeft();
                break;
            default:
                // if necessary, process/log invalid commands
                break;
        }
    }

    /**
     *  Move rover in currently facing direction preventing him to go out of the boundary of given area
     */
    private function move()
    {
        //  if necessary, process the tried movement out of boundary (log them, etc.)
        switch ($this->facing) {
            case 'N':
                if ($this->position[self::Y] < $this->area[self::Y])
                    $this->position[self::Y]++;
                break;
            case 'S':
                if ($this->position[self::Y] > 0)
                    $this->position[self::Y]--;
                break;
            case 'W':
                if ($this->position[self::X] > 0)
                    $this->position[self::X]--;
                break;
            case 'E':
                if ($this->position[self::X] < $this->area[self::X])
                    $this->position[self::X]++;
                break;
        }
    }

    private function rotateRight()
    {
        $current = array_search($this->facing, self::FACING);
        $this->facing = self::FACING[$current == 0 ? count(self::FACING) - 1 : $current - 1];
    }

    private function rotateLeft()
    {
        $current = array_search($this->facing, self::FACING);
        $this->facing = self::FACING[$current == count(self::FACING) - 1 ? 0 : $current + 1];
    }

}
