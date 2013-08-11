#!/bin/bash
echo 'Remove folders'
rm -rf httpdocs/
rm -rf subdomains/boston/
rm -rf subdomains/dc/
rm -rf subdomains/mi/
rm -rf subdomains/nyc/
rm -rf subdomains/beta/

echo 'Copy folders'
cp -r subdomains/dev httpdocs
cp -r subdomains/dev subdomains/boston
cp -r subdomains/dev subdomains/dc
cp -r subdomains/dev subdomains/mi
cp -r subdomains/dev subdomains/nyc
cp -r subdomains/dev subdomains/beta

php bin/replace.php
echo 'Done'