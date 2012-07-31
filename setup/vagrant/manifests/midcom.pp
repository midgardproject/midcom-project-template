exec { '/usr/bin/apt-get update':
  timeout => 0
}

class { 'midcom':
}

exec { '/usr/sbin/a2dissite 000-default':
  require => Package['apache2'],
  notify => Service['apache2']
}

exec { 'composer_install':
  command => '/usr/local/bin/composer install',
  timeout => 0,
  cwd => '/midcom',
  environment => ['MIDCOM_MIDGARD_CONFIG_FILE=/etc/midgard2/conf.d/midgard2.conf', 'COMPOSER_PROCESS_TIMEOUT=4000'],
  require => [
    Exec['download_composer'],
    Package['php5-cli', 'php5-midgard2']
  ]
}

file { 'midgard_php_config':
  path => '/etc/php5/conf.d/midgard2.ini',
  source => 'puppet:///modules/midcom/midgard2.ini',
  require => Exec['composer_install'],
  notify => Service['apache2']
}

# FIXME: For now we need a second composer run to get database tables built
exec { 'composer_install2':
  command => '/usr/local/bin/composer install',
  timeout => 0,
  cwd => '/midcom',
  environment => ['MIDCOM_MIDGARD_CONFIG_FILE=/etc/midgard2/conf.d/midgard2.conf', 'COMPOSER_PROCESS_TIMEOUT=4000'],
  require => Exec['composer_install']
}
