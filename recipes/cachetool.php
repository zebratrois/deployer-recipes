<?php
namespace Deployer;

set('bin/cachetool', function () {
    if (test('[ -f {{deploy_path}}/.dep/cachetool.phar ]')) {
        return '{{bin/php}} {{deploy_path}}/.dep/cachetool.phar';
    }

    if (commandExist('cachetool')) {
        return '{{bin/php}} ' . which('cachetool');
    }

    warning("Cachetool binary wasn't found. Installing latest cachetool to \"{{deploy_path}}/.dep/cachetool.phar\".");
    run("cd {{deploy_path}}/.dep/ && curl -sLO https://github.com/gordalina/cachetool/releases/latest/download/cachetool.phar");
    return '{{bin/php}} {{deploy_path}}/.dep/cachetool.phar';
});

desc('Clear PHP opcode cache');
task('cachetool:opcache:clear', function () {
    run("{{bin/cachetool}} opcache:reset");
});

desc('Clear APCu cache');
task('cachetool:apcu:clear', function () {
    run("{{bin/cachetool}} apcu:cache:clear");
});

desc('Clear file stat cache');
task('cachetool:stat:clear', function () {
    run("{{bin/cachetool}} stat:clear");
});
