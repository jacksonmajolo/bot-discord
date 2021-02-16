<?php

namespace Lib\Annotation;

/**
 * Class Command
 * @package App\Annotation
 * @Annotation
 */
class Command
{
    public $command;

    public function __construct(array $values)
    {
        $this->command = $values['name'] ?? NULL;
    }

    public function getCommand()
    {
        return $this->command;
    }
}
