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
  cwd => '/midcom',
  environment => 'MIDGARD_ENV_GLOBAL_SHAREDIR=/midcom/config/share',
  require => [
    Exec['download_composer'],
    Package['php5-cli', 'php5-midgard2']
  ]
}
