Yumrepo <| |> -> Package <| |>

node default {
  include '::ntp'
  class { '::epel': }
  class { '::timezone':
        timezone => 'UTC',
  }
  class { 'supervisord':
    install_pip  => true,
    install_init => true,
    nocleanup    => true,
  }


  if defined(Package['java-1.7.0-openjdk']) {
    notice("Package: java-1.7.0-openjdk already defined.")
  } else {
    package {'java-1.7.0-openjdk':
      ensure => installed,
    }
  }

#  class fermata {
    $app_home = '/app'
    # Create the fermata user
    user { 'fermata':
      ensure            =>  'present',
      uid               =>  7004,
      gid               =>  'fermata',
      shell             =>  '/sbin/nologin',
      home              =>  "${app_home}/fermata",
      comment           =>  'fermata email server user',
      managehome        =>  true,
      require           =>  [ Group['fermata'], File['app_base_dir'] ],
    }

    # Create a matching group
    group { 'fermata':
      gid               => 7004,
    }

    # Ensure the home directory exists with the right permissions
    file { 'app_base_dir':
      name              => "${app_home}",
      ensure            =>  'directory',
      mode              =>  '0755',
    } ~>

    # Ensure the home directory exists with the right permissions
    file { "${app_home}/fermata":
      ensure            =>  'directory',
      owner             =>  'fermata',
      group             =>  'fermata',
      mode              =>  '0755',
      require           =>  [  User['fermata'], Group['fermata'], File['app_base_dir'] ],
    } ~>
 
    staging::deploy { "fermata-0.7.tar.gz":
      source => "http://ghsoftware.s3.amazonaws.com/fermata-0.7.tar.gz",
      target => "${app_home}/fermata",
    }

    supervisord::program { 'fermata':
      command           => "/usr/bin/java -jar -Dport=9092 ${app_home}/fermata/fermata-0.7/fermata.war",
      directory         => "${app_home}/fermata",
      autostart         => true,
      autorestart       => 'true',
      redirect_stderr   => true,
      stdout_logfile    => "fermata.log",
      user              => 'fermata',
    }
#  }

  class { '::apache':
    docroot => '/vagrant/htdocs',
  }
  
  class { 'apache::mod::php':  }
}

