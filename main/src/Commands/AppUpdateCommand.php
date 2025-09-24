<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:update', 'Update app to the latest version.')]
class AppUpdateCommand extends Command {}
