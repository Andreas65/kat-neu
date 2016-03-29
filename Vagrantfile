# -*- mode: ruby -*-
# vi: set ft=ruby :

# global configuration
VAGRANTFILE_API_VERSION = "2"
VAGRANT_BOX = "unister-debian-wheezy64-0.7.0"
VAGRANT_BOX_MEMORY = 2048
VIRTUAL_BOX_NAME = "kat-neu"

NFS_ENABLED = true
NFS_MOUNT_OPTIONS  = ["proto=tcp", "vers=3", "actimeo=2", "nolock"]
NFS_EXPORT_OPTIONS = ["async", "rw", "no_subtree_check", "all_squash"]

# only change these lines if you know what you do
Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    nfs_enabled    = NFS_ENABLED && RbConfig::CONFIG['host_os'] =~ /linux|mac|darwin/
    mount_options  = nfs_enabled ? NFS_MOUNT_OPTIONS  : []
    export_options = nfs_enabled ? NFS_EXPORT_OPTIONS : []

    config.vm.box = VAGRANT_BOX
    config.vm.box_url = "http://apps.qa.unister.lan/packages/boxes/vagrant/" + VAGRANT_BOX + ".box"
    config.vm.hostname = VIRTUAL_BOX_NAME + ".local"

    # configure vhost ports, more vhosts => more port forwarding definitions
    config.vm.network :forwarded_port, guest: 80, host: 8110, auto_correct: true
    config.vm.network :forwarded_port, guest: 443, host: 8175, auto_correct: true
    # mysql server port forwarding
    config.vm.network :forwarded_port, guest: 3306, host: 13306, auto_correct: true

    config.vm.network :private_network, ip: "192.168.56.2", nic_type: "82540EM"

    # Vagrant 1.5 supports rsync (maybe faster)
    #config.vm.synced_folder ".", "/vagrant", type: "rsync", rsync__auto: true, rsync__exclude: [".git/", ".vagrant", ".idea", "nbproject"]
    config.vm.synced_folder ".", "/vagrant", :nfs => nfs_enabled, :mount_options => mount_options, :linux__nfs_options => export_options

    # forward ssh requests for public keys
    config.ssh.forward_agent = true

    # ensure box name
    config.vm.define VIRTUAL_BOX_NAME do |t|
    end

    config.vm.provider :virtualbox do |vb|
        vb.name = VIRTUAL_BOX_NAME
        vb.customize ["modifyvm", :id, "--memory", VAGRANT_BOX_MEMORY]
        vb.customize ['modifyvm', :id, '--cpus', 1]
        vb.customize ['modifyvm', :id, '--nictype1', '82540EM']
        vb.customize ['modifyvm', :id, '--nictype2', '82540EM']
        vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
        vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    end

    if Vagrant.has_plugin?("vagrant-cachier")
        config.cache.scope = :box
        config.cache.enable :composer
        config.cache.enable :apt
        config.cache.enable :bower
        config.cache.enable :npm
        config.cache.enable :gem
    end

    # script for provisioner initializing
    config.vm.provision :shell, :path => "http://apps.qa.unister.lan/packages/puppet-install/debian-0.3.0.sh"

    config.vm.provision :puppet do |puppet|
        puppet.facter = {
            "ssh_username" => "vagrant"
        }
        puppet.manifests_path = "puppet/manifests"
        puppet.manifest_file = "site.pp"
        puppet.options = ["--verbose", "--hiera_config /vagrant/puppet/hiera.yaml", "--parser future"]
    end
end
