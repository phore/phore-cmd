<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 24.07.19
 * Time: 10:50
 */

namespace Phore\Cmd;


class PhoreCmdParam
{

    private $name;
    private $shortName = null;
    private $desc;
    private $filterFn = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setShortName(string $shortName) : self
    {
        $this->shortName = $shortName;
        return $this;
    }




    public function getName() : string
    {
        return $this->name;
    }

    public function setRequired()
    {

    }

    public function setFilter(callable $fn)
    {

    }

    public function setDescription($description) : self
    {
        $this->desc = $description;
        return $this;
    }


    public function __highlight()
    {
        $desc = $this->shortName ?? $this->name;
        if ($this instanceof PhoreCmdValueParam)
            $desc = $this->shortName ?? $this->name . " <value>";
        echo "\n  " . str_pad($desc, 16) . $this->desc;
    }


    public function __exec_filter($value)
    {
        if ($this->filterFn !== null)
            return ($this->filterFn)($value);
        return $value;
    }


}
