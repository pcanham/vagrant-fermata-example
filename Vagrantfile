# -*- mode: ruby -*-
# vi: set ft=ruby :

$script = <<SCRIPT
puppet module install --force puppetlabs-firewall
puppet module install --force puppetlabs-ntp
puppet module install --force puppetlabs-stdlib
puppet module install --force puppetlabs-concat
puppet module install --force puppetlabs-apache
puppet module install --force saz-timezone
puppet module install --force stahnma-epel
puppet module install --force nanliu-staging
puppet module install --force ajcrowe-supervisord
SCRIPT


Vagrant.configure("2") do |config|

  config.vm.box = "puppetlabs/centos-6.6-64-puppet"
  config.vm.box_check_update = true

  config.vm.provider :virtualbox do |vb, override|
    vb.gui = true
    vb.customize [
      "modifyvm", :id,
      "--memory", "512",
      "--cpus", "4",
      "--natdnspassdomain1", "off",
      ]
  end

  config.vm.provider :vmware_fusion do |v, override|
    v.vmx["memsize"] = 1024
    v.vmx["numvcpus"] = 4
  end


  boxes = [
    { :name => :mailtest, :ip => '10.0.0.20', :memory => 1024, :puppetmanifest => 'vagrant.pp', :puppetenv => 'production' }
  ]

  boxes.each do |opts|
    config.vm.define opts[:name] do |config|
      config.vm.provider :virtualbox do |v|
        v.customize ["modifyvm", :id, "--memory", opts[:memory] ]
      end
      config.vm.provider :vmware_fusion do |v|
        v.vmx["memsize"] =  opts[:memory]
      end
      config.vm.network   :private_network, ip: opts[:ip]
      config.vm.hostname  = "%s.sandbox.internal" % opts[:name].to_s
      config.vm.provision :shell, :inline => $script
      config.vm.provision :puppet,
        :options => ["--debug", "--verbose", "--summarize"],
        :facter => { "fqdn" => "%s.sandbox.internal" % opts[:name].to_s } do |puppet|
          puppet.environment = "%s" % opts[:puppetenv].to_s
      end
    end
  end
end
