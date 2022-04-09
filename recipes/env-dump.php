<?php
namespace Deployer;

desc('Dumps .env file for current env');
task('env:dump', function () {
    $stage = currentHost()->get('stage');
    $env = 'dev' == $stage ? 'dev' : 'prod';
    run("cd {{release_or_current_path}} && cp .env." . $stage . " .env.local");
    run("cd {{release_or_current_path}} && {{bin/composer}} dump-env " . $env);
});
