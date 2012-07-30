class midcom {
  $home_path = '/home/vagrant'
  $bin_dir = '/usr/local/bin'
  $project_path = '/midcom'

  $dbuser = 'midgard'
  $dbpass = 'midgard'
  $dbname = 'midgard'

  # The PHP and Apache environment with Midgard2
  package { ['php5-cli', 'php5-midgard2', 'apache2', 'libapache2-mod-php5', 'libgda-4.0-mysql', 'php5-memcache', 'php-apc']:
      ensure => latest;
  }

  # SSH should go straight to project root
  file { "${home_path}/.bash_aliases":
      content => "cd ${project_path}";
  }

  # We need these in order to run Composer
  package { ['git-core', 'curl']:
      ensure => latest;
  }

  exec { 'download_composer':
    command => '/usr/bin/curl -s http://getcomposer.org/installer | /usr/bin/php',
    cwd => $home_path,
    require => [
      Package['curl', 'php5-cli'],
    ],
    creates => "${home_path}/composer.phar";
  }

  file { $bin_dir:
    ensure => directory;
  }

  file { "${bin_dir}/composer":
    ensure => present,
    source => "${home_path}/composer.phar",
    require => [
      Exec['download_composer'],
      File[$bin_dir],
    ],
    mode => '0755'
  }

  # Set up PHP timezone
  file { '/etc/php5/conf.d/01-settings.ini':
    source => 'puppet:///modules/midcom/01-settings.ini',
    require => Package['php5-cli'],
    notify => Service['apache2']
  }

  # Set up vhost
  file { '/etc/apache2/sites-available/midcom.lo':
    source => 'puppet:///modules/midcom/midcom.lo',
    require => Package['apache2'],
    notify => Service['apache2']
  }

  # Start Apache2
  service { 'apache2':
    ensure => running,
    hasrestart => true,
    hasstatus => true,
    require => Package['apache2']
  }

  # Enable mod_rewrite
  exec { '/usr/sbin/a2enmod rewrite':
    require => Package['apache2'],
    notify => Service['apache2']
  }

  # Enable vhost
  exec { '/usr/sbin/a2ensite midcom.lo':
    require => Package['apache2'],
    notify => Service['apache2']
  }

  # MySQL setup
  package { ['mysql-server', 'mysql-client']:
    ensure => latest
  }

  service { 'mysql':
    enable => true,
    ensure => running,
    require => Package['mysql-server']
  }

  # Some extra stuff needed by MidCOM
  package { ['imagemagick', 'rcs', 'memcached']:
    ensure => latest
  }

  exec { 'create_database':
    unless => "/usr/bin/mysql -u${dbuser} -p${dbpass} ${dbname}",
    command => "/usr/bin/mysql -uroot -p -e \"create database ${dbname}; grant all on ${dbname}.* to ${dbuser}@localhost identified by '${dbpass}';\"",
    require => Service['mysql']
  }

  # Set up Midgard2 config
  file { 'midgard_config':
    path => "/etc/midgard/conf.d/midgard2.conf",
    source => 'puppet:///modules/midcom/midgard2.ini',
    require => Package['php5-midgard2']
  }

  # Remove unnecessary example config
  tidy { '/etc/midgard2/conf.d/midgard.conf.example': }
}
