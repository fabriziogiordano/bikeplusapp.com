#!/bin/bash
echo 'Remove folders'
rm -rf httpdocs/
rm -rf subdomains/beta/
rm -rf subdomains/boston/
rm -rf subdomains/chicago/
rm -rf subdomains/dc/
rm -rf subdomains/mi/
rm -rf subdomains/nyc/

echo 'Copy folders'
cp -r subdomains/dev httpdocs; echo 'httpdocs'
cp -r subdomains/dev subdomains/beta; echo 'beta'
cp -r subdomains/dev subdomains/boston; echo 'boston'
cp -r subdomains/dev subdomains/chicago; echo 'chicago'
cp -r subdomains/dev subdomains/dc; echo 'dc'
cp -r subdomains/dev subdomains/mi; echo 'mi'
cp -r subdomains/dev subdomains/nyc; echo 'nyc'

php bin/replace.php
echo 'Done'
