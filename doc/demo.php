<?php



$cmd = new PhoreCmd();
$cmd->createValParam("-v")->desc("Some description")->required()->validate(function ($val) { echo wurst; });
$cmd->createBoolParam("-b")->desc("Other description");

$createCmd = $cmd->createSubCmd("create");

$createEntityVal = $createCmd->createSubVal("repoName")->description
