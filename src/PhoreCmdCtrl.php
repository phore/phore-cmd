<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 24.07.19
 * Time: 10:45
 */

namespace Phore\Cmd;


class PhoreCmdCtrl
{

    const DEFAULT_COMMAND = "__default_cmd__";
    private $descName = "";
    private $desc = "";

    /**
     * @var PhoreCmdParam[]
     */
    private $params = [];

    /**
     * @var PhoreCmdCommand[]
     */
    private $cmds = [];


    public function __construct(string $programName, string $description)
    {
        $this->desc = $programName;
        $this->desc = $description;
    }


    public function addParam (PhoreCmdParam $param) : self
    {
        $this->params[$param->getName()] = $param;
        return $this;
    }

    public function addCmd(PhoreCmdCommand $command) : self
    {
        return $this;
    }


    public function defineParam(string $name) : PhoreCmdParam
    {
        $param = new PhoreCmdParam($name);
        $this->params[$param->getName()] = $param;
        return $param;
    }


    public function defineCommand(string $name = self::DEFAULT_COMMAND) : PhoreCmdCommand
    {
        $cmd = new PhoreCmdCommand($name);
        $this->cmds[$cmd->getName()] = $cmd;
        return $cmd;
    }



    public function printUsage()
    {
        echo $this->descName;
        echo "\n";
        echo $this->desc;
        echo "\n";

        echo "\nArguments:";
        foreach ($this->params as $param)
            $param->highlight();
    }


    public function parse(array $arguments=null) {
        if ($arguments === null) {
            $arguments = $GLOBALS["argv"];
            array_shift($arguments);
        }
        $cmdParams = [];
        while (true) {
            $curVal = array_shift($argv);
            if (substr($curVal, 0, 2) === "--") {
                $name = substr($curVal, 2);
                if ( ! isset ($this->params[$name]))
                    throw new \InvalidArgumentException("Unrecognized parameter: '--$name'");
                $param = $this->params[$name];
                if ($param instanceof PhoreCmdValueParam) {
                    $value = array_shift($arguments);
                    $cmdParams[$param->getName()] = $value;
                } else {
                    $cmdParams[$param->getName()] = true;
                }
            } else if (substr($curVal, 0, 1) === "-") {
                $name = substr($curVal, 1);
                if ( ! isset ($this->params[$name]))
                    throw new \InvalidArgumentException("Unrecognized parameter: '-$name'");
                if ($param instanceof PhoreCmdValueParam) {
                    $value = array_shift($arguments);
                    $cmdParams[$param->getName()] = $value;
                } else {
                    $cmdParams[$param->getName()] = true;
                }
            } else {
                $name = $curVal;
                if ( ! isset ($this->cmds[$name]))
                    throw new \InvalidArgumentException("Unrecognized command: '$name'");
                $this->cmds[$name]->__run($cmdParams);
            }
        }
    }



}
