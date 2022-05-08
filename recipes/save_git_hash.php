<?php
namespace Deployer;

set('git_commit_hash', function() {
    $git = get('bin/git');
    $hash = runLocally("$git log --pretty=format:'%h' -n 1");
    return $hash;
});

set('git_hash_files', [
    /*
    [
        'files' => 'config/*.xml', // source files glob
        'search' => '<hash></hash>', // string to replace by commit hash
        'replace' => '<hash>GITHASH</hash>', // replacement string where GITHASH is the commit hash
    ],
    */
]);

desc('Get git commit hash');
task('save_git_hash', function () {
    cd('{{release_path}}');
    $hash = get('git_commit_hash');
    $files = get('git_hash_files');
    foreach ($files as $file) {
        foreach (explode(PHP_EOL, run('ls ' . $file['files'])) as $path) {
            $cmd = 'sed -e ' . escapeshellarg('s|' . $file['search'] . '|' . str_replace('GITHASH', $hash, $file['replace']) . '|') . ' <' . $path . ' >' . $path . '.tmp';
            $cmd .= '; mv ' . $path . '.tmp ' . $path;
            run($cmd);
        }
    }
});
