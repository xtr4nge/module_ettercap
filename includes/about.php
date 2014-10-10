<b>Ettercap</b>  was  born  as  a sniffer for switched LAN (and obviously even "hubbed" ones), but during the development process it has gained more and more features that have changed it to a powerful and flexible tool for man-in-the-middle attacks.  It supports active and passive dissection of many protocols (even ciphered ones) and includes many features for network and host analysis (such as OS fingerprint).

<br><br>It has two main sniffing options:

<br><br>UNIFIED,  this method sniffs all the packets that pass on the cable. You can choose to put or not the interface in promisc mode (-p option). The packet not directed to the host running ettercap will be forwarded automatically using layer 3 routing. So you can use a mitm attack launched from a different  tool  and  let  ettercap modify the packets and forward them for you.
<br><br>The  kernel  ip_forwarding  is  always  disabled by ettercap. This is done to prevent to forward a packet twice (one by ettercap and one by the kernel).  This is an invasive behaviour on gateways. So we recommend you to use ettercap on the gateways ONLY with the UNOFFENSIVE MODE ENABLED. Since ettercap listens only on one  network interface, launching it on the gateway in offensive mode will not allow packets to be rerouted back from the second interface.

<br><br>BRIDGED,  it  uses  two  network  interfaces  and forward the traffic from one to the other while performing sniffing and content filtering. This sniffing method is totally stealthy since there is no way to find that someone is in the middle on the cable.  You can look at this method as a mitm attack at layer 1. You will be  in the  middle  of  the  cable  between two entities. Don't use it on gateways or it will transform your gateway into a bridge. HINT: you can use the content filtering engine to drop packets that should not pass. This way ettercap will work as an inline IPS ;)

<br><br>You can also perform man in the middle attacks while using the unified sniffing. You can choose the mitm attack that you prefer. The mitm attack module is  independent  from the sniffing and filtering process, so you can launch several attacks at the same time or use your own tool for the attack. The crucial point is that the packets have to arrive to ettercap with the correct mac address and a different ip address (only these packets will be forwarded).

<br><br><b>Original Authors</b>
<br>Alberto Ornaghi (ALoR) [alor@users.sf.net]
<br>Marco Valleri (NaGA) [naga@antifork.org]
