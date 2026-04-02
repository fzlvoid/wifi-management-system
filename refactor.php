<?php
$dashboardPath = __DIR__ . '/resources/views/dashboard/index.blade.php';
$content = file_get_contents($dashboardPath);

if (preg_match('/(<aside\b.*?<\/aside>)/is', $content, $matches)) {
    $asideContent = $matches[1];
    $componentPath = __DIR__ . '/resources/views/components/sidebar.blade.php';
    if (!is_dir(dirname($componentPath))) {
        mkdir(dirname($componentPath), 0755, true);
    }
    file_put_contents($componentPath, $asideContent);
    echo "Sidebar extracted\n";
    
    $files = [
        __DIR__ . '/resources/views/dashboard/index.blade.php',
        __DIR__ . '/resources/views/packages/index.blade.php',
        __DIR__ . '/resources/views/packages/form.blade.php',
        __DIR__ . '/resources/views/customers/create.blade.php',
        __DIR__ . '/resources/views/customers/deactivated.blade.php',
        __DIR__ . '/resources/views/customers/delete.blade.php',
        __DIR__ . '/resources/views/admin/users/index.blade.php',
        __DIR__ . '/resources/views/admin/users/create.blade.php',
        __DIR__ . '/resources/views/admin/users/edit.blade.php',
    ];
    
    foreach ($files as $file) {
        if (!file_exists($file)) continue;
        $fileContent = file_get_contents($file);
        $newContent = preg_replace('/\{\?*--.*SIDEBAR.*--\}?\s*/is', '', $fileContent);
        $newContent = preg_replace('/<aside\b.*?<\/aside>/is', '<x-sidebar />', $newContent);
        file_put_contents($file, $newContent);
        echo "Replaced in: " . basename($file) . "\n";
    }
} else {
    echo "Fail.\n";
}
