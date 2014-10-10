#!/bin/bash

echo "installing ettercap..."
#apt-get -y install ettercap

apt-get -y install unzip
apt-get -y install cmake libncurses5-dev libssl-dev libpcap-dev flex bison libgtk2.0-dev

wget https://github.com/Ettercap/ettercap/archive/v0.8.0.tar.gz
tar zxvf v0.8.0.tar.gz
cd ettercap-0.8.0
mkdir build
cd build
cmake ../
make
make install
ln -s /usr/local/bin/ettercap /usr/sbin/ettercap

echo "..DONE.."
exit
