<?php
namespace Deployer;

desc('Reload Apache');
task('apache:reload', function () {
    run("sudo /usr/sbin/apache-control reload");
});

desc('Restart Apache');
task('apache:restart', function () {
    run("sudo /usr/sbin/apache-control restart");
});
