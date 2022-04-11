<?php
namespace Deployer;

require 'contrib/yarn.php';

desc('Build assets');
task('yarn:build', function () {
    $target = 'prod' == currentHost()->get('stage') ? 'build' : 'dev';
    run("cd {{release_or_current_path}} && {{bin/yarn}} " . $target);
});

before('yarn:build', 'yarn:install');
