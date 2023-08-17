<?php return array(
    'root' => array(
        'pretty_version' => '6.5',
        'version' => '6.5.0.0',
        'type' => 'shopware-platform-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'kreatif/sia-pay',
        'dev' => true,
    ),
    'versions' => array(
        'kreatif/sia-pay' => array(
            'pretty_version' => '6.5',
            'version' => '6.5.0.0',
            'type' => 'shopware-platform-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
        'sia-vpos/vpos-client-php-sdk' => array(
            'pretty_version' => '1',
            'version' => '1.0.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../sia-vpos/vpos-client-php-sdk',
            'aliases' => array(),
            'reference' => 'master',
            'dev_requirement' => false,
        ),
    ),
);
