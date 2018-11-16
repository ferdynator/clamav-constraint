# ClamAv-Constraint

[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.png?v=103)](https://opensource.org/licenses/mit-license.php)

This is a custom Symfony anti-virus validator for file uploads.
It uses the [Quahog](https://github.com/jonjomckay/quahog) library 
to connect to a running clamav unix socket and scan the uploaded file.

This repository is strongly influenced by the [clamav-validator for laravel](https://github.com/sunspikes/clamav-validator) 
and the [TissueBundle](https://github.com/Evozon-PHP/TissueBundle).

## Installation

    composer require ferdynator/clamav-constraint
    
Also make sure you have [`ClamAv`](http://www.clamav.net/documents/installing-clamav) installed.

## Usage

Add this constraint in your entity of choice:

    use ferdynator\ClamAvConstraint\Validator\Constraints as VirusAssert;

    class JobImage {
        
        ...
        
        /*
         * ...
         * @VirusAssert\ClamAv
         */
        protected $file;

        ...
    }


### Configuration

#### Alternative socket

In case you are not using a unix socket or have it in a non-standard position
you can pass an alternative socket-url:

    /*
     * ...
     * @VirusAssert\ClamAv(
     *     socket="tcp://0.0.0.0:1234"
     * )
     */
    protected $file;
    
#### File permissions

The `clamav` daemon needs read-access to the uploaded file. You can specify 
a chmod-mode with the `chmod` option of the constraint.

    /*
     * ...
     * @VirusAssert\ClamAv(
     *     chmod=0600
     * )
     */
    protected $file;
    
