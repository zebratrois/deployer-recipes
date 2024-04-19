<?php
namespace Deployer;

set('revision_hash', function() {
    cd('{{release_or_current_path}}');
    $hash = run('cat REVISION ');

    return $hash;
});

desc('Save revision hash to ASSET_HASH .env var');
task('env:asset_hash', function () {
    $hash = substr(get('revision_hash'), 0, 6);
    cd('{{release_or_current_path}}');
    $cmd = 'sed -e ' . escapeshellarg('s|ASSET_HASH=""|ASSET_HASH="' . $hash . '"|') . ' < .env > .env.tmp';
    $cmd .= '; mv .env.tmp .env';
    run($cmd);
});
