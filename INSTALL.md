# INSTALLATION

Informations about the installation process.

## SYSTEM REQUIREMENTS

- PHP >= 5.5
- Vagrant >= 1.5

## VIRTUAL MACHINE (VM)

Vagrant is used to create a fully running and configured application.
Make sure you have at least version 1.5 of Vagrant (`vagrant --version`).
If this is not the case start reading [the documentation about updating Vagrant yourself](https://confluence.unister.lan/x/eJZK).

After that just run `vagrant up`. Vagrant than will download the right base box (if not already done) and start the VM.
The provisioning process (bunch of bash- and puppet scripts) then will configure the system,
install the project dependencies and configure the application with Phing.

## INSTALL DEPENDENCIES

Composer is used to manage dependencies. If someone had updated the dependencies you'll have to run
`composer install` inside the virtual machine to get their used version.

For updating the the dependencies run `composer update`. After that commit the `composer.json` and `composer.lock`.

You should also update Composer with `composer self-update` from time to time.

## CONFIGURE THE APPLICATION

Phing is used the configure the application:

```
cd build
./bin/phing -Dconfig.file=development.properties
```
