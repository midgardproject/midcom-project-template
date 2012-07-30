midcom-project-template
========================

(Experimental) Template for setting up [MidCOM](http://midgard-project.org/midcom/)-based projects.

## Where is everything?

The MidCOM project template follows a file structure designed for both easy bootstrapping of new projects, and for managing existing projects in a version control system.

* `config`: application configuration files, including [Midgard2](http://midgard-project.org/midgard2/) database setup
* `var`: volatile application data, like logs and cache
* `src`: application's own MidCOM components
* `theme`: application's MidCOM templates
* `web`: document root for the application, to be used with your web server
* `setup`: setup and installation tools, including Vagrant and Puppet configuration
* `vendor`: dependencies including MidCOM and components. Managed by Composer

## Creating new MidCOM projects

This project template is designed to be used together with the [Composer](http://getcomposer.org/) PHP dependency management tool. You can create new MidCOM projects on your current machine with:

    $ php composer.phar create-project midgard/midcom-project-template myproject

This will download the MidCOM project template and set it up together with the dependencies. This new project will be set up in the `myproject` directory.

**Note**: Even though Midgard2 supports multiple relational databases, the current setup scripts are written for MySQL only.

## Creating development VMs with Vagrant

[Vagrant](http://vagrantup.com) gives an easy way to manage development virtual machines using MidCOM.

### Dependencies

* [Vagrant](http://vagrantup.com)
* NFS (out-of-the-box in OS X, on Debian-based Linux systems install `nfs-kernel-server`)

### Installation

To set up a Vagrant project, download this project template, and then:

    $ cd setup/vagrant
    $ vagrant up

The `up` command will download a Ubuntu 12.04 base image, start it in [VirtualBox](https://www.virtualbox.org/) and then use the [Puppet](http://puppetlabs.com/) configuration management system to set up Midgard2, PHP, Apache, and your MidCOM project.

This setup can take a long time depending on your internet connection. Once it is done, there should be a MidCOM instance running based on your project setup. You can access it at <http://localhost:8181>.

### Usage

The Vagrant VM will mount your project directory over NFS, and so all of your file changes will apply to the virtual machine instantly. If you need to tweak something on the VM, you can get an SSH connection to it with:

    $ vagrant ssh

Your mounted project directory will be available in `/midcom`.

### Managing the virtual machine

You can use the `vagrant halt` command to stop your virtual machine, and `vagrant up` to restart it.

If you want to start from scratch, simply run `vagrant destroy`, and rebuild the VM image with another `vagrant up`.

If you want to distribute your VM image with your team, read the [Vagrant packaging documentation](http://vagrantup.com/v1/docs/getting-started/packaging.html).
