<?php
// vim: set expandtab ts=4 sw=4 nu
// NetIO230 
// Based on ideas provided from Philipp Klaus git://gist.github.com/271987.git
// Author: Walter Werther


/*
 * Exception Class for NetIO-Devices
 *
 * I just want my own Exception-Class so it's easier to handle them in try/catch blocks
 *
 * List of return-codes from NetIO I saw so far:
 *      100 -> HELLO Message            -> normally this won't raise an exception
 *      110 -> QUIT Message             -> normally this won't raise an exception
 *      250 -> OK                       -> normally this won't raise an exception
 *      502 -> Unknown Command
 *      503 -> Invalid login
 *      505 -> Forbidden
 *      506 -> Input line to long
 *
 */
class NetIO230Exception extends Exception {
    public function __tostring () {
        return  __CLASS__.'('.$this->code.') - '.$this->message;
    }
}

/*
List of available commands (taken from http://www.koukaam.se/koukaam/downloads/MAN_DE_NETIO-230B_3-00.pdf):

It seems like not all commands are supported, even though they are listed in the manual and the firmware-version is upgraded to the most recent one

 
login <name><password> 
    Anmeldung des Benutzers mit einem offenen Passwort. Beispiel: Mit dem Befehl login admin admin melden Sie sich mit dem Benutzernamen admin und dem Passwort admin an.

clogin <name><crypted password> 
    Anmeldung des Benutzers mit einem verschlüsselten Passwort. 
    
version 
    Zeigt alle Firmware Versionen an.

alias 
    Zeigt die aktuellen Geraetenamen an.

quit 
    Logout. Bei Änderungen in der Systemeinstellung wird das Gerät neu gestartet.

reboot 
    Logout der aktuellen Session und das Geät startet neu.
    110 -> Bye

noop 
   Die Verbindung wird gehalten, es wird keine Operation durchgefuehrt. Geeignet bei der mechanischen Bedienung des Geraetes.

uptime 
   Zeigt das Uptime des Geraetes an.

port <output>[0/1/manual/int] 
   Anzeige und Änderung des aktuellen Status:
    * Zeigt aktuellen Portstatus bei Eingabe der Portnummer: (0 - OFF / 1 - ON)
    * Output Nummer und 0/1 Parameter – disable/enable output
    * Output Nummer und ’manual’ - Parameter – Enable Manual Output Steuerung
    * Output Nummer und ’int’ Parameter – Setzt Interrupt auf Output
    Beispiel: Befehlport 2 1 schaltet Ausgang 2 auf ON.

port list [xxxx] Port List:
    * Ohne angegebenen Parameter wird die Liste aller Output mit aktuellem Staus ausgegeben
    * xxxx Über den Befehl können alle Outputs gleichzeitig gesteuert werden - anstelle von x tragen Sie die möglichen Befehle ein:
        * 0 - Schalten des Ausgangs auf OFF
        * 1 - Schalten des Ausgangs auf ON
        * i - Schalten des Ausgangs auf Interrupt
        * u - ohne Status¨anderung am Ausgang
    Beispiel: Befehl port list 01ui schaltet Ausgang 1 OFF, schaltet Ausgang 2 ON, Ausgang 3 unverändert und auf Ausgang 4 wird Interrupt gesetzt.

port setup<output>[<output name><mod:manual/timer><interrupt delay><PON status>]
    Befehl für Äderung der Ausgangsparameter – die Parameter haben folgende Bedeutung:
        * <output name> - Setzen Sie den Namen in Anführungszeichen (kann auch ohne Anführungszeichen gesetzt werde, wenn keine weißen Zeichen enthalten sind).
        * <mod:manual/timer> - Wahl des Ausgangsregimes
        * <PON status>
            *   0 schaltet auf OFF / 
            *   1 schaltet auf ON
    Beispiel: Befehl port setup 1 "output 1" manual 2 setzt: 
        Ausgang 1 Name: output 1
        Enable Manual Control
        Interruption interval auf 2 Sekunden and power on state auf ON.
        
port timer <output><time format>[ <mode: once/daily/weekly><on-time><off-time>] <week schedule>
    Einstellung des Timers:
        * <output> - Nummer des eingestellten Outputs
        * <time format> - Format der Zeiteinstellung
        * t - HH:MM:SS
        * dt - YYYY/MM/DD,HH:MM:SS
        * ux - xxxxxxxx ( unsigned long mit dem Pr¨afix 0x<hex>, 0<octal>oder dekadisch)
        * <mode once/daily/weekly> - Wahl des Timer Regimes.
        * <on-time> - Einschalten des Outputs.
        * <off-time> - Ausschalten des Outputs.
        * <week sched.> - Einser-Nuller-Reihe, erste Zahl entspricht Montag, letzte Zahl Sonntag
    Beispiel: Befehl port timer 3 t weekly 08:00:00 17:30:00 1111100 schaltet den Timer auf Output
        3. Von Montag bis Freitag schaltet sich Output 3 jeden Tag um 8 Uhr ein und um 17:30 Uhr aus.
        port wd <output> Setzt die Funktionseinstellung f ¨ ur Watchdog im jeweiligen Ausgang in das Format:
        <wd: enable/disable><wd ip addr><wd timeout><wd PON delay><ping refresh><max retry><max retry poff:
        enable/disable><send email: enable/disable>
        
port wd <output><wd: enable/disable> 
        Gestattet oder verbietet die Funktion Watchdog. P?r´iklad:
        Befehl port wd 4 enable schaltet die Funktion Watchdog an Ausgang 4 ein.
        port wd<output>< wd:enable/disable><wd ip addr><wd timeout><wd PON delay><ping
        interval><max retry><max retry poff:enable/disable><send email:enable/disable>
        Befehl f ¨ ur die Watchdog Einstellung. Die Parameter haben folgende Bedeutung:
    * <output> - Nummer des Ausgangs, den Sie einstellen
    * <wd: enable/disable> - Zulassung / Verbot der Funktion f ¨ ur Watchdog am jeweiligen Ausgang
    * <wd ip addr> - IP Adresse des ¨uberwachten Ger¨ates in Sekunden
    * <wd timeout> - Max.-Zeit f ¨ ur die Antwort des ¨uberwachten Ger¨ ats
    * <wd POn delay> - Zeitintervall (in Sekunden), in der die Funktion nach dem Neustart
        aktiv wird. In dieser Zeit sollte das ¨uberwachte Ger¨ at seine T¨ atigkeit nach den Neustart
        aufnehmen.
    * <ping interval> - Intervall (in Sekunden), in dem Fragen zum Ger¨ at gesendet werden
    * <max retry> - Max.-Anzahl der Neustarts eines Ausgangs f ¨ ur den Fall, dass das ¨uberwachte
        Ger¨ at nicht auf den Ping reagiert. Nach Ablauf der eingegebenen Versuche bleibt der Ausgang
        ausgeschaltet.
    * <max retry poff: enable/disable> - ON / OFF Funktionmax retry
    * <send email: enable/disable> - ON / OFF Versenden von E-Mails, wenn das ¨uberwachte
        Ger¨ at nicht verf ¨ugbar ist, ggf. wenn der Wert max retry ¨uberschritten wurde.
        Beispiel: Befehl port wd 2 enable 192.168.10.101 10 30 1 3 enable enable gestattet die Funktion
        watchdog am Ausgang 2. U¨ berwacht wird das Gera¨ t an der Adresse 192.168.10.101. Die
        H¨ochstzeit f ¨ ur die Antwort des ¨uberwachten Ger¨ates betr ¨agt 10 Sekunden. Die Ping-Befehle werden
        im Sekundentakt gesendet. Antwortet das ¨uberwachte Ger¨ at nicht nach 10 Sekunden, wird
        Ausgang 2 f ¨ ur 30 Sekunden ausgeschaltet. Antwortet das Ger¨ at auch nach den eingestellten drei
        Ausschaltungen immer noch nicht auf die Ping Anfragen, schaltet sich der Ausgang ein viertes Mal
        aus ohne neu zu starten. Bei jedem Ausschalten des Ausgangs wird eine Warn-E-Mail versendet.
        
system eth 
    Zeigt die Einstellungen der Internetschnittstelle im Format:
    <dhcp/manual><ip address><mask><gateway>

system eth <dhcp/manual>[<ip address><mask><gateway>] 
    Einstellung der Netzwerkschnittstellenparameter
    – IP-Adresse, Subnet mask und Gateway Parameter Einstellungen
    sind nur notwendig, wenn Manual mode angew¨ ahlt ist. Um die neuen Einstellungen wirksam
    werden zu lassen, muss das System ¨uber den Reboot Befehl oder ON / OFF NETIO neu gestartet
    werden.
    Beispiel: Befehl system eth manual 192.168.10.150 255.255.255.0 192.168.10.1 
    setzt
        IP-Adresse auf 192.168.10.150, 
        Subnet Mask auf 255.255.255.0 
        Default Gateway auf 192.168.10.1

email server <ip/domain server address>
    Setzt die IP-Adresse oder Domain Name des SMTP Servers.

system discover 
    Zeigt die Sichtbarkeit des Ger¨ates f ¨ ur das Discover Utility im Netzwerk (Enable / Disable).

system discover <enable/disable> 
    Setzt die Sichtbarkeit des Ger¨ates f ¨ ur das Discover Utility im Netzwerk auf Enable / Disable.


system swdelay 
    Zeigt die Verzögerungszeit zwischen dem Schalten zweier Ausg¨ange.

system swdelay <delay> 
    Setzt eine Verzögerungszeit zwischen dem Schalten zweier Ausgänge (Sekunden).

system dns 
    Zeigt die aktuelle Ziel-Adresse des DNS Server.

system dns <ip>
    Setzt die Ziel-Adresse des DNS Server. Um die neuen Einstellungen wirksam werden zu lassen muss das Gerät neu gestartet werden,
    über den reboot Befehl oder Aus- und Wiedereinschalten NETIO.

system dst 
    Zeigt die Sommerzeiteinstellung im Format: enabled/disabled yyyy/mm/dd,hh:mm:ss

system dst <enable/disble>
    Schaltet die Sommerzeit ein oder aus.

system dst begin yyyy/mm/dd,hh:mm:ss 
    Stellt das Datum für den Beginn der Sommerzeit ein.

system dst end yyyy/mm/dd,hh:mm:ss
    Stellt das Datum für das Ende der Sommerzeit ein.

system sntp 
    Zeigt die Einstellungen für den SNTP Client.

system sntp <enable/disable><sntp ip/domain> 
    Einstellung des SNTP Client. Gestattet (enable), oder verbietet (disable) die Zeitsynchronisation mit dem SNTP Server. Die Serveradresse kann
    als IP Adresse eingegeben werden oder unter dem Namen der Domain.

system time 
    Zeigt die Ortszeit an.

system time <YYYY/MM/DD,HH:MM:SS> 
    Einstellung der Ortszeit.

system timezone
    Zeigt die Zeitverschiebung von UTC für die Ortszeit an. Der Wert wird in Sekunden angezeigt.

system timezone <+/-offset> 
    Einstellung der lokalen Zeitzone. Die Zeitversetzung wird in Sekunden angegeben.

system update 
    Schaltet das Gerät in den Firmware Upgrade Mode.

system reset to default 
    Rücksetzen aller Einstellungen auf Factory DefaultWerte. Nach Durchführung dieses Befehls startet das Gerät neu.

system webport <port>

system kashport <port>

*/

/*
 * NetIo230 class
 *
 * This class is used to handle all requests and commands the NetIO-Devices support. I'm using the KShell, interface since it looks like, that it is 
 * fitting better to the specification and documentation than the CGI-Interface. At least I was not able to build up a proper communication using CGI instead of Telnet.
 *
 * Even though not all commands that are listed in the manual are really supported by the device (for whatever reason)
 *
 */ 
class netio230 {
    
	public $errorMessage;
	public $kshell_version;


	private $address; 	    // IP-Address of Netio-Device to control
	private $port;	    	// Port that should be used for connection
	private $user;	    	// Login Credentials (User)
    private $password;  	// Login Credentials (Password)
    private $dosecurelogin; // Should we use the CLogin function instead of the login function? -> defaults to true

    // For internal usage
    private $socket;        // the connection-socket
    private $login_hash;    // the hash returned when establishing the connection

    private $lastrc;        // the last return-code

	public function __construct ($host,$user,$password,$dosecurelogin=true,$port=1234) {
	        /* Get the IP address for the target host. */
		$this->address=gethostbyname($host);
		$this->port=$port;
		$this->user=$user;
        $this->password=$password;

        $this->dosecurelogin=$dosecurelogin;

        $this->socket=null;
    }
    
    public function connect() {

        if ($this->socket) {
            throw new netio230exception("socket already exists");
        }

        $this->socket = fsockopen($this->address,$this->port,$errno,$errstr,0.30);
        if ( ! $this->socket ) {
            throw new netio230exception("problem with tcp connection-attempt. Reason: ($errno) " . $errstr,$errno);
        }

        if (! $read = $this->_readmessage()) {
            throw new netio230exception("problem with first tcp read-attempt. Reason: ($read) " . socket_strerror(socket_last_error($this->socket)),1);
        } else {
		    $this->_log("Hash: $this->login_hash");
		    $this->_log("Version: $this->kshell_version");
        }
    }

    /* Does a login to the netio230 device */
    public function login() {
        $pw=$this->password;
        $command='login';
        if ($this->dosecurelogin) {
            $command='clogin';
            $pw=md5($this->user.$this->password.$this->login_hash);
        }

        $result=$this->query($command,$this->user,$pw);
        
        if ($this->lastrc!=250) {
            throw new netio230exception("login failed - ".$result,$this->lastrc);
        }
    }

    /* reboots the device */
    public function reboot() {
        $result=$this->query('reboot');
        if ($this->lastrc!=110) {
            throw new netio230exception("reboot failed - ".$result,$this->lastrc);
        }
    }

   /* does a proper disconnect from the device */
    public function disconnect() {
        if ($this->socket) {
            $this->query('quit');
            // closing socket
            socket_close($this->socket);
        }
        $this->socket=null;
    }

    public function getPortOnOff($number) {
        $result=$this->query('port',$number);
        if ($this->lastrc!=250) {
            throw new netio230exception("query for port failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function setPortOnOff($number,$value) {
        $result=$this->query('port',$number,$value);
        if ($this->lastrc!=250) {
            throw new netio230exception("query for port failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getPortSetup($number) {
        $result=$this->query('port','setup',$number);
        if ($this->lastrc!=250) {
            throw new netio230exception("query for port setup failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getPortName($number) {
        $setup=$this->getPortSetup($number);

        preg_match('/"(.+?)"\s(.+?)\s(.+?)\s(.+?)/',$setup,$matches);
        array_shift($matches);
        list($name,$mode,$interrupt_delay,$ponstatus)=$matches;
        return $name;
    }

    public function setPortName($number) {
        $result=$this->query('port','setup',1);
        if ($this->lastrc!=250) {
            throw new netio230exception("query for version failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getPortStatus() {
        $result=$this->query('port','list');
        if ($this->lastrc!=250) {
            throw new netio230exception("query for port status failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getVersion() {
        $result=$this->query('version');
        if ($this->lastrc!=250) {
            throw new netio230exception("query for version failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getAlias() {
        $result=$this->query('alias');
        if ($this->lastrc!=250) {
            throw new netio230exception("query for alias failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function getUptime() {
        $result=$this->query('uptime');
        if ($this->lastrc!=250) {
            throw new netio230exception("query for uptime failed - ".$result,$this->lastrc);
        }
        return $result;
    }

    public function noop() {
        return $this->query('noop');
    }

    public function query($command) {
        $numargs = func_num_args();
        $arg_list=null;
        if ($numargs >= 2) {
            $arg_list = func_get_args();
            array_shift($arg_list);
        }
        $this->_writemessage($command,$arg_list);
        return $this->_readmessage();
    }

    private function _writemessage($command,$attributes) {
        if (! $this->socket) {
            throw new netio230exception("socket not properly opened");
        }

        if (is_null($attributes)) {
            $out=$command."\r\n";
        } else {
            if (is_array($attributes)) {
                $attr='';
                foreach ($attributes as $a) {
                    if (strpos($a,' ')) {
                        $a='"'.$a.'"';
                    } 
                    $attr.=' '.$a;
                }
            } else {
                if (strpos($attributes,' ')) {
                    $attr='"'.$attributes.'"';
                } else {
                    $attr=$attributes;
                }
            }
            $out = $command.' '.$attr."\r\n"; # It's important to terminate all commands with \r\n
        }

        $this->_log("WRITE: ".rtrim($out));

        fputs ($this->socket,$out);
#       $result=socket_write($this->socket, $out, strlen($out));
#       if (socket_last_error($this->socket)) {
#           $this->lastrc=-socket_last_error($this->socket);
#           throw new netio230exception('Socket-Write error ('.socket_last_error($this->socket).')'.socket_strerror(socket_last_error($this->socket)),-socket_last_error($this->socket));
#	}
    }

	private function _readmessage() {
        if (! $this->socket) {
            throw new netio230exception("socket not properly opened");
        }

        $in=rtrim(@fgets($this->socket, 1024));
#        if (socket_last_error($this->socket)) {
#            $this->lastrc=-socket_last_error($this->socket);
#            throw new netioexception('Socket-Read error ('.socket_last_error($this->socket).')'.socket_strerror(socket_last_error($this->socket)),-socket_last_error($this->socket));
#        }
 
        $this->_log("READ: $in");

		$this->lastrc=substr($in,0,3);
		$in=substr($in,4);

		if ($this->lastrc==100) {
			list($msg,$this->login_hash,$sep,$this->kshell_version) = explode(' ',$in,4);
		}

		return $in;
    }

    private function _log($text) {
#        print "$text\n";
        $text='';
    }
   
    public function __destruct() {
        $this->disconnect();          
    }


    public function __tostring() {
        $text='';
        if ($this->socket) {
            $text='KShell-Version: '.$this->kshell_version."\n";
            $text.='Version: '.$this->getVersion()."\n";
            $text.='Alias: '.$this->getAlias()."\n";
#            $text.='Uptime: '.$this->getUptime()."\n";
        }
        return $text;
    }

}

try {
	$netio = new netio230($_GET['device'],'admin','admin');
	$netio->connect();
	#$netio->disconnect();
	#$netio->connect();
	$netio->login();

	#$output = $netio->getPortStatus()."-".$netio->getVersion();
	#$output = $netio->reboot();
	#
	$output = '';

	#for ($i=1;$i<=4;$i++) {
	#    $netio->setPortOnOff($i,1-$netio->getPortOnOff($i));
	#    $output.=$netio->getPortName($i).':'.$netio->getPortOnOff($i)."\n";
	#}
	#$output =$netio->getPortOnOff(3,1);

	if ($_GET['action']=='name') {
	    $output=$netio->getPortName($_GET['port']);
	    print $output;
	    exit;
	}
	if ($_GET['action']=='get') {
	    $output=$netio->getPortOnOff($_GET['port']);
	    print $output;
	    exit;
	}
	if ($_GET['action']=='set') {
	    $output=$netio->setPortOnOff($_GET['port'],$_GET['value']);
	    print $output;
	    exit;
	}
	if ($_GET['action']=='toggle') {
	    $output=$netio->setPortOnOff($_GET['port'],1-$netio->getPortOnOff($_GET['port']));
	    print $output;
	    exit;
    }
} catch (NetIO230Exception $E) {
    header("HTTP/1.0 500 $E");
    print $E;
    exit;
}

?>
<html>
<head>
<title>Control the Koukaam NETIO 230</title>
</head>
<body>
<br>
<?=$output?>
</body>
</html>

