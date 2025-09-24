<?php

namespace Kernery\Main\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('kernery:app:install', 'Install, publish and migrate app.')]
class InstallAppCommand extends Command {}
