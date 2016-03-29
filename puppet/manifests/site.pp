include apt
include developer
include php
include developer::apache2
include developer::memcache
include sass
include phantomjs

class {
  'developer::phpnext':;
}

package { 'gettext':
    before => Developer::Phing['skeleton-phing-install']
}

# Apache 2
developer::apache2::vhost { 'www':
  priority        => '10',
  port            => '80',
  ssl             => false,
  basedir         => '/vagrant',
  publicdir       => 'public',
  profiling       => false
}

developer::apache2::vhost { 'ssl':
  priority        => '10',
  port            => '443',
  ssl             => true,
  basedir         => '/vagrant',
  publicdir       => 'public',
  profiling       => false
}

sass::watch { 'sass-skeleton-watch':
  watch => 'data/assets/sass:data/assets/css',
  cwd   => '/vagrant'
}

# mysql db
class { '::mysql::server':
  root_password    => 'dev',
  override_options => {
    'mysqld' => { 'bind-address' => '0.0.0.0' }
  }
}

# allow access from host to mysql server wit password dev
mysql_user { 'root@10.0.2.2':
  ensure                   => 'present',
  max_connections_per_hour => '0',
  max_queries_per_hour     => '0',
  max_updates_per_hour     => '0',
  max_user_connections     => '0',
  password_hash            => '*27AEDA0D3A56422C3F1D20DAFF0C8109058134F3',
  require                  => [Mysql::Db["skeleton"]]
}

# get full access from host to mysql server
mysql_grant { 'root@10.0.2.2/*.*':
  ensure     => 'present',
  options    => ['GRANT'],
  privileges => ['ALL'],
  table      => '*.*',
  user       => 'root@10.0.2.2',
  require    => [Mysql_User["root@10.0.2.2"]]
}

mysql::db { 'skeleton':
  user     => 'root',
  password => 'dev',
  host     => '127.0.0.1',
  grant    => ['all'],
  sql      => '/vagrant/database/create.sql'
}

# prevent timeout of composer install
Exec <| title == "composer_update_skeleton-composer-install" |> {
  timeout => 0
}

# composer
composer::exec { 'skeleton-composer-install':
  cmd                  => 'install',  # REQUIRED
  cwd                  => '/vagrant/build', # REQUIRED
  custom_installers    => true,
  scripts              => true,
  user                 => 'vagrant'
}

# Installation of the application. requires db and composer install
developer::phing { 'skeleton-phing-install':
  target    => 'install -Dconfig.file=development.properties',
  require   => [Composer::Exec['skeleton-composer-install'], Mysql::Db['skeleton']],
  path      => '/vagrant/build/',
  phingbin  => '/vagrant/build/vendor/bin/phing',
  buildfile => '/vagrant/build/build.xml'
}

# Grunt and Grunt Survival pack
class { 'nodejs':
  version => 'v0.12.2',
  before  => Class['phantomjs'],
}

file { 'nodejs-bin-symlink':
  target  => '/usr/local/node/node-default/bin/node',
  path    => '/usr/local/bin/node',
  ensure  => link,
  require => Class['nodejs'],
}

file { 'npm-bin-symlink':
  target  => '/usr/local/node/node-default/bin/npm',
  path    => '/usr/local/bin/npm',
  ensure  => link,
  require => Class['nodejs'],
}

file { 'grunt-bin-symlink':
  target  => '/usr/local/node/node-default/bin/grunt',
  path    => '/usr/local/bin/grunt',
  ensure  => link,
  require => Class['nodejs'],
}

package { 'express':
  provider        => npm,
  install_options => ['-g']
}
package { 'grunt-cli':
  provider        => 'npm',
  install_options => ['-g']
}

exec { 'grunt-survival-pack-install':
  command => '/bin/bash ./vendor/bin/gsp.sh --install',
  cwd     => '/vagrant/build',
  require => [
    Composer::Exec['skeleton-composer-install'],
    File['nodejs-bin-symlink'],
    File['npm-bin-symlink'],
    File['grunt-bin-symlink'],
    Package['express'],
    Package['grunt-cli'],
  ],
}

package { 'php5-apcu':
  ensure  => installed,
  require => Package['php5-cli'],
}
package { 'php5-memcached':
  ensure  => installed,
  require => Package['php5-cli'],
}
package { 'php5-imagick': 
  ensure  => installed,
  require => Package['php5-cli'],
}
