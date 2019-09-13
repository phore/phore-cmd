<?php


namespace Phore\Cmd;


use http\Exception\InvalidArgumentException;

class PhoreCmd
{

    protected $name;

    protected $subCmds = [];

    /**
     * @var null|self
     */
    protected $subVal = null;

    protected $params = [];

    /**
     * @var null|callable
     */
    protected $action = null;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }


    public function dispatch(array $argv = null, array $parsedArgs = [])
    {
        if ($argv === null) {
            $argv = $GLOBALS["argv"];
            array_shift($argv);
        }

        while(true) {
            $curArg = array_shift($argv);

            if (substr ($curArg, 0, 1) === "--") {
                $argName = substr($curArg, 2);
                if ( ! isset ($this->params[$argName]))
                    throw new \InvalidArgumentException("Argument '$curArg' undefined.");
                $parsedArgs[$argName] = 1;
                continue;
            }

            if ($this->subVal !== null) {
                $parsedArgs[$this->subVal->name] = $curArg;
                $this->subVal->dispatch($argv, $parsedArgs);
            }
        }

    }

}
