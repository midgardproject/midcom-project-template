exec { '/usr/bin/apt-get update':
  timeout => 0
}

class { 'midcom':
}

exec { 'composer_install':
  command => '/usr/local/bin/composer install',
  cwd => '/midcom',
  require => [
    Exec['download_composer'],
    Package['php5-cli', 'php5-midgard2']
  ]
}
