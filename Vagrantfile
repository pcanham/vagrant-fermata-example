# -*- mode: ruby -*-
# vi: set ft=ruby :

$script = <<SCRIPT
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

  config.vm.box = "puppetlabs-vbox-centos-65-x64"
  config.vm.box_check_update = true

  config.vm.provider :virtualbox do |vb, override|
    override.vm.box_url = "http://puppet-vagrant-boxes.puppetlabs.com/centos-65-x64-virtualbox-puppet.box"
    vb.gui = true
    vb.customize [
      "modifyvm", :id,
      "--memory", "512",
      "--cpus", "4",
      "--natdnspassdomain1", "off",
      ]
  end

  config.vm.provider :vmware_fusion do |v, override|
    override.vm.box = "puppetlabs-vmware-centos-65-x64"
    override.vm.box_url = "http://puppet-vagrant-boxes.puppetlabs.com/centos-64-x64-fusion503.box"
    v.vmx["memsize"] = 1024
    v.vmx["numvcpus"] = 4
  end


  boxes = [
    { :name => :mailtest, :ip => '10.0.0.20', :memory => 1024, :puppetmanifest => 'vagrant.pp' }
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
          puppet.manifests_path = "./"
          puppet.manifest_file = opts[:puppetmanifest]
      end
    end
  end
end