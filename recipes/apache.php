<?php
namespace Deployer;

desc('Reload Apache');
task('apache:reload', function () {
    $cmd = file_exists('/usr/sbin/apache-control') ? '/usr/sbin/apache-control' : '/usr/sbin/service apache2';
    run("sudo " . $cmd . " reload");
});

desc('Restart Apache');
task('apache:restart', function () {
    $cmd = file_exists('/usr/sbin/apache-control') ? '/usr/sbin/apache-control' : '/usr/sbin/service apache2';
    run("sudo " . $cmd . " restart");
});
