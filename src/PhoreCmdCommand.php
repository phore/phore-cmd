<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 24.07.19
 * Time: 10:49
 */

namespace Phore\Cmd;


class PhoreCmdCommand
{

    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function description($desc)
    {

    }

    public function run($callback)
    {

    }

    public function __execute($params)
    {

    }

}
