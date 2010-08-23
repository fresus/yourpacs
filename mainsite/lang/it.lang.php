<?php
/**
Language Italiano
@file en.lang.php
@version 1.0
@date 6 de abril del 2007
@author Macos Julian <marcos@Yourpacs.com>
@revision Azucena Casado
@revision Albert Sellares <whats@Yourpacs.com>

* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

# General
# ------------------------------------------------------------------------------
$LANG['general']['by']       = "Da";
$LANG['general']['of']       = "di";
$LANG['general']['to']       = "a";
$LANG['general']['and']      = "e";
$LANG['general']['or']       = "o";
$LANG['general']['with']     = "width";
$LANG['general']['years']    = "anni";
$LANG['general']['author']   = "Autore";
$LANG['general']['the']      = "il/la";
$LANG['general']['day']      = "giorno";
$LANG['general']['accept']   = "Accetto";
$LANG['general']['send']     = "Invia";
$LANG['general']['comments'] = "Commenti";

$LANG['general']['options'] = "Opzioni";
$LANG['general']['help']    = "Aiuto";
$LANG['general']['save']    = "Sala";
$LANG['general']['change']  = "Cambia";

$LANG['general']['dayweek_0'] = "domenica";
$LANG['general']['dayweek_1'] = "lunedi";
$LANG['general']['dayweek_2'] = "martedi";
$LANG['general']['dayweek_3'] = "mercoledi";
$LANG['general']['dayweek_4'] = "giovedi";
$LANG['general']['dayweek_5'] = "venerdi";
$LANG['general']['dayweek_6'] = "sabato";

# Sections
# ------------------------------------------------------------------------------
$LANG['email']['nasubject'] = "Benvenuto/a in Yourpacs. Dati iscrizione.";
$LANG['email']['nabody']    = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
								<html><head>
								<title>Yourpacs :: Conferma iscrizione</title>
								<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
								</head><body>
								<h1>Benvenuto/a in Yourpacs</h1><br/>
								Ora puoi iniziare a usare la tua iscrizione a Yourpacs.
								Da questo momento puoi accedere al tuo pannello di controllo e modificare i dati della tua iscrizione, scoprendo tutti i vantaggi che Yourpacs ti offre.
								<br/><br/>
								Questi sono i dati della tua iscrizione:<br/>
								Nome iscrizione: <strong>[%LOGIN%]</strong><br/>
								Password: <strong>[%PASSWD%]</strong><br/>
								Indirizzo web: http://[%LOGIN%].Yourpacs.com<br/>
								<br/>
								Per accedere alle tue pagine come amministratore, puopi usare i seguenti dati::<br/>
								Nome: <strong>admin</strong><br/>
								Password: <strong>[%ADMINPASSWD%]</strong><br/>
								<br/>
								Ti ringraziamo per la fiducia accordata a Yourpacs.<br/>
								http://www.Yourpacs.com<br/>
								support@Yourpacs.com
								</body></html>
								";

$LANG['email']['rpsubject'] = "Yourpacs. Password recovery.";
$LANG['email']['rpbody']    = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
								<html><head>
								<title>Yourpacs :: Recupero password</title>
								<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
								</head><body>
								<h1>Recupero password</h1><br/>
								E' stato generato un codice di sicurezza perchè tu possa cambiare la tua password su Yourpacs. Questo codice è valido per 30 minuti. Se scorre questo tempo senza che tu lo usi, il codice perde la sua validità e dovrai richiederne un altro. <br/><br/>
								Informazioni sulla tua iscrizione:<br/>
								Nome: <strong>[%LOGIN%]</strong><br/>
								e-Mail: <strong>[%EMAIL%]</strong><br/>
								<br/>
								Per cambiare la password clikka questo link:<br/>
								<a href=\"[%URL%]\">[%URL%]</a>
								<br/><br/>
								Ti ringraziamo per la fiducia accordata a Yourpacs.<br/>
								http://www.Yourpacs.com<br/>
								support@Yourpacs.com
								</body></html>
								";

# Sections
# ------------------------------------------------------------------------------
$LANG['sections']['whatis']   = "Cosa è Yourpacs?";
$LANG['sections']['sothat']   = "A cosa serve?";
$LANG['sections']['because']  = "Perchè scegliere Yourpacs?";
$LANG['sections']['contact']  = "Contatti";
$LANG['sections']['register'] = "Crea nuova iscrizione";
$LANG['sections']['help']     = "Aiuto";

# Pager
# ------------------------------------------------------------------------------
$LANG['pager']['page']   = "Pagina";
$LANG['pager']['pages']  = "Pagine";
$LANG['pager']['next']   = "Successiva";
$LANG['pager']['prev']   = "Precedente";
$LANG['pager']['first']  = "Prima";
$LANG['pager']['last']   = "Ultima";

# Summary
# ------------------------------------------------------------------------------
$LANG['summary']['pagetitle']   = "Yourpacs :: ";
$LANG['summary']['optionblog']  = "Blog (il tuo diario)";
$LANG['summary']['optionalbum'] = "Album (per le immagini)";
$LANG['summary']['optionwiki']  = "Wiki (scrittura condivisa)";
$LANG['summary']['optionlinks'] = "Links (collegamenti)";
$LANG['summary']['optionforum'] = "Forum (per discutere)";

$LANG['summary']['lastphotos'] = "Immagini recenti";
$LANG['summary']['nophotos']   = "Non ci sono immagini al momento";
$LANG['summary']['lastblog']   = "Contributi recenti";
$LANG['summary']['noentries']  = "Non ci sono contributi al momento";
$LANG['summary']['lastwiki']   = "Contributi recenti";
$LANG['summary']['lastlinks']  = "Collegamenti recenti";
$LANG['summary']['nolinks']    = "Non ci sono collegamenti al momento";
$LANG['summary']['lastforum']  = "Messaggi recenti";
$LANG['summary']['noforum']    = "Non ci sono messaggi al momento";

# Header
# ------------------------------------------------------------------------------
$LANG['header']['language']     = "Langua:";
$LANG['header']['enterYourpacs'] = "Entra";
$LANG['header']['welcome']      = "Benvenuto/a";
$LANG['header']['newaccount']   = "Registrazione";
$LANG['header']['haveaccount']  = "Entro";
$LANG['header']['disconnect']   = "Scollegami";
$LANG['header']['sentfriend']   = "Voglio raccomandare Yourpacs a un amico";
$LANG['header']['gotocpanel']   = "Pannello di controllo";

# Footer
# ------------------------------------------------------------------------------
$LANG['footer']['license'] = "Condizioni del Servizio";
$LANG['footer']['copy']    = ":: Yourpacs - 2007 ::";
$LANG['footer']['info']    = "Yourpacs è software libero liberato sotto licenza
							  <a href=\"http://www.gnu.org/copyleft/gpl.html\">GNU/GPL</a>";

# Section: Home
# ------------------------------------------------------------------------------
$LANG['home']['pagetitle']  = "Yourpacs :: Crea per te un blog, una pagina personale, un forum di comunta', degli albums fotografici , un Wiki, etc., in modo veloce, facile e gratuito";
$LANG['home']['starttitle'] = "Crea per te un blog, una pagina personale, un forum di comunta',
							   degli albums fotografici , un Wiki, etc., in modo veloce, facile e gratuito!";
$LANG['home']['startdesc']  = "Benvenuti nel mondo del web gratuito. <strong>Yourpacs</strong>
							   è un servizio che raggruppa le migliori applicationi gratuite esistenti. Se sei esperto,
							   ma anche se non sei esperto, puoi controllare completamente tutte le applicationi di <strong>Yourpacs</strong>,
							   usando gli strumenti messi a disposizione, senza restrizioni. Non dimenticare che il
							   mondo della gratuità non finisce mai. <strong>Yourpacs</strong> procede di continuo e ogni giorno
							   attiverà nuove applicazioni, strumenti e moduli per le tue pagine.";
$LANG['home']['enddesc']    = "Scrivi<strong>qualsiasi cosa</strong>,
							   ad<strong>ogni ora</strong>,
							   <strong>da ogni posto</strong>,
							   <strong>sempre</strong> attivo.";
$LANG['home']['createtitle'] = "Iscriviti in 3 semplici passi";
$LANG['home']['onestep']     = "Scegli un nome";
$LANG['home']['twostep']     = "Scegli una categoria";
$LANG['home']['threestep']   = "Clikka \"accetto\"";
$LANG['home']['arrowcreate'] = "Iscriviti ora!";
$LANG['home']['randomusers'] = "Ultimi utenti";
$LANG['home']['lastposts']   = "Alcune entrate nel Blogs";

# Section: Login
# ------------------------------------------------------------------------------
$LANG['login']['pagetitle'] = "Yourpacs :: Entra";
$LANG['login']['error1']    = "Nome o password scagliati";

$LANG['login']['enterl']        = "Entra in Yourpacs";
$LANG['login']['recoverpass']   = "Recupera password";
$LANG['login']['sentcode']      = "Hai ricevuto una email di conferma";
$LANG['login']['emailnoexists'] = "Questa email non esiste";
$LANG['login']['changepass']    = "Cambia password";
$LANG['login']['change']        = "Cambia";

# Section: New account
# ------------------------------------------------------------------------------
$LANG['newaccount']['pagetitle']      = "Yourpacs :: Nuova iscrizione";
$LANG['newaccount']['summary']        = "Creare una nuova iscrizione è facile.";
$LANG['newaccount']['onesteptitle']   = "Scegli un nome";
$LANG['newaccount']['twosteptitle']   = "Scegli una categoria";
$LANG['newaccount']['threesteptitle'] = "Clikka accetto";

$LANG['newaccount']['desctitle'] = "Crea un'iscrizione a Yourpacs";
$LANG['newaccount']['desc']      = "Compila il seguente formulario con le informazioni richieste e avrai la
									tua iscrizione attivata immediatamente. Tutte le informazioni sono obbligatorie
									e <strong>ricorda</strong>: la email è necessaria per mandarti le informazioni
									sulla tua iscrizione e la password, ma anche per informarti dei cambiamenti
									effettuati da <strong>Yourpacs</strong>, con le relative istruzioni affichè
									tu possa usare le novità. Ti raccomandiamo di usare un indirizzo postale
									valido e che usi abitualmente.";
$LANG['newaccount']['name']      = "Utente";
$LANG['newaccount']['captcha']   = "Codice di sicurezza";
$LANG['newaccount']['verify']    = "Verifica";
$LANG['newaccount']['email']     = "e-Mail";
$LANG['newaccount']['cemail']    = "Conferma e-Mail";
$LANG['newaccount']['password']  = "Password";
$LANG['newaccount']['cpassword'] = "Conferma password";
$LANG['newaccount']['acceptthe'] = "Accetto le";
$LANG['newaccount']['terms']     = "condizioni d'uso";
$LANG['newaccount']['ofYourpacs'] = "";

$LANG['newaccount']['error'][0] = "Richiesta";
$LANG['newaccount']['error'][1] = "Non è uguale";
$LANG['newaccount']['error'][2] = "Non valida o inesistente";
$LANG['newaccount']['error'][3] = "Almeno 6 caratteri";
$LANG['newaccount']['error'][4] = "Non è uguale";
$LANG['newaccount']['error'][5] = "Scegli la categoria";
$LANG['newaccount']['error'][6] = "Non accetto";

$LANG['newaccount']['maintetitle'] = "Maintenance";
$LANG['newaccount']['maintenance'] = "We are currently performing maintenance and
									  it is not possible to create new accounts.
									  <br/><br/>
									  This action has started at 19:00h
									  (GMT +1) and end at 21:00h (GMT +1).
									  <br/><br/>
									  Sorry for the inconvenience.";

# Section: Control panel
# ------------------------------------------------------------------------------
$LANG['controlpanel']['warning']          = "Attenzione";
$LANG['controlpanel']['useradmin']        = "Nome amministratore";
$LANG['controlpanel']['passadmin']        = "Password amministratore";
$LANG['controlpanel']['wchangepassdesc1'] = "Hai già una password assegnata ";
$LANG['controlpanel']['wchangepassdesc2'] = "con questa puoi accedere alle tue pagine e configurarle.
											 L'<strong>admin</strong> è richiesto per configurare le pagine,
											 con el opzioni desiderate. Ti raccomandiamo di cambiare la password dal
											 menu \"Configura pagine\", per poter accedere in modo semplice e facile
											 da ricordare.";
$LANG['controlpanel']['pagetitle']        = "Yourpacs :: Pannello di controllo";
$LANG['controlpanel']['desctitle']        = "Pannello di controllo";
$LANG['controlpanel']['desc']             = "Da qui puoi cambiare i dati della tua iscrizione e la forma delle
											 tue pagine. Puoi anche selezionare la tua pagina iniziale e darle la forma
											 che preferisci.";
$LANG['controlpanel']['menu']             = "Menu";
$LANG['controlpanel']['home']             = "Home";
$LANG['controlpanel']['configYourpacs']    = "Configura Yourpacs";
$LANG['controlpanel']['configwebs']       = "Configura i servizi web";
$LANG['controlpanel']['configdomain']     = "Configura dominio";
$LANG['controlpanel']['installsoft']      = "Installi / Deinstall";
$LANG['controlpanel']['startweb']         = "Prima pagina ";
$LANG['controlpanel']['logaccess']        = "Registro dei cambiamenti";
$LANG['controlpanel']['freespace']        = "Spazio libero";
$LANG['controlpanel']['using']            = "Sto usando";
$LANG['controlpanel']['available']        = "disponibile";
$LANG['controlpanel']['mydataccount']     = "Mia iscrizione";
$LANG['controlpanel']['name']             = "Nome:";
$LANG['controlpanel']['email']            = "e-Mail:";
$LANG['controlpanel']['dateadded']        = "Data creazione:";
$LANG['controlpanel']['urlhome']          = "Indirizzo home:";
$LANG['controlpanel']['titleaccess']      = "Registro delle ultime 50 configurationi effttuate ";
$LANG['controlpanel']['nologaccess']      = "Registro vuoto";
$LANG['controlpanel']['myblog']           = "Mio blog";
$LANG['controlpanel']['myweb']           = "Mio web";
$LANG['controlpanel']['mywiki']           = "Mio wiki";
$LANG['controlpanel']['mylinks']          = "Miei links";
$LANG['controlpanel']['myalbum']          = "Mio album";
$LANG['controlpanel']['myforum']          = "Mio forum";
$LANG['controlpanel']['samepass']         = "Non può essere la stessa dell'iscrizione a Yourpacs";
$LANG['controlpanel']['shortpass']        = "E' troppo corta";

$LANG['controlpanel']['configsuccess']      = "Fatto";
$LANG['controlpanel']['configstats']        = "Cambia la password di accesso alle statistiche ";
$LANG['controlpanel']['configstatspasswd']  = "Password:";
$LANG['controlpanel']['statspasswdsuccess'] = "Password cambiata";


$LANG['controlpanel']['mypagesdata']        = "Informationi sulle mie pagine";
$LANG['controlpanel']['mypagesdatadesc']    = "Puoi accedere alla tua pagine dai seguenti punti:";
$LANG['controlpanel']['configaccount']      = "Configurazione iscrizione";
$LANG['controlpanel']['configallpages']     = "Configurazione delle mie pagine";
$LANG['controlpanel']['configallpagesdesc'] = "Con questa opzione puoi cambiare la password dell' \"<strong>admin</strong>\" di tutte le tua pagine simultaneamente.";
$LANG['controlpanel']['cadminpasswdsuc']    = "Password modificata";
$LANG['controlpanel']['configwiki']         = "Configurazione Wiki";
$LANG['controlpanel']['configwordpress']    = "Configurazione Blog";
$LANG['controlpanel']['configwikititle']    = "Titolo:";
$LANG['controlpanel']['configwikiurl']      = " Immagine Url:";
$LANG['controlpanel']['configwikilang']     = "Lingua:";
$LANG['controlpanel']['configwikitheme']    = "Tema grafico:";
$LANG['controlpanel']['selectstartpage']    = "Scegli la pagina di inizio";
$LANG['controlpanel']['selectstartpagedesc'] = "Puoi usare come pagina di inizio una pagina di sommario di
												tutti i contributi o usare direttamente una delle tue pagine.";

$LANG['controlpanel']['configsuccess']       = "Fatto";
$LANG['controlpanel']['domain']                = "Dominio:";
$LANG['controlpanel']['configdomaintitle']     = "Messa a punto di dominio";
$LANG['controlpanel']['configdomaindesc']      = "Qui, potete installare il vostro sopra dominio. Per fare così, dovete indicare il vostro dominio a";
$LANG['controlpanel']['configdomainconfirm']   = "Siete sicuri?";
$LANG['controlpanel']['success']               = "Dominio aggiunto";
$LANG['controlpanel']['success2']              = "Dominio cancellato";
$LANG['controlpanel']['error1']                = "Non è un dominio valido";
$LANG['controlpanel']['error2']                = "Il vostro dominio non è configurato";
$LANG['controlpanel']['deletedomain']          = "Dominio di cancellazione";
$LANG['controlpanel']['newsmail']              = "Mi mandi d'e-Mail le notizie e gli aggiornamenti";

$LANG['controlpanel']['restorewp']             = "Recuperare:";
$LANG['controlpanel']['restorewpdesc']         = "<i>(Disattiva tutti plugins e mette il theme dal difetto)</i>";
$LANG['controlpanel']['confirmrestorewp']      = "Questa opzione, disattiva tutti plugins e mette il theme dal difetto di Lynksse. Dal pannello di controllo del vostro Blog potrete rinviare per attivare plugins ed il theme del ponerte che desiderate. ¿Questo cassaforte?";
$LANG['controlpanel']['installsofttitle']      = "Inaugurare o rimuovere software";
$LANG['controlpanel']['installsofterror1']     = "Non inscatolare tu rimuovere tutti";
$LANG['controlpanel']['installsofterror2']     = "Tu porto marcatamente suo riparo di conferma";
$LANG['controlpanel']['installsoftdesc']       = "<strong>IMPORTANTE:</strong> Se deinstalls un software, la configurazione ed il soddisfare sarete rimossi per sempre. Noi recomends per controllare lo spazio libero (avete bisogno di circa 20MBytes per software)";
$LANG['controlpanel']['installsoftsuccess']    = "Fatto.";
$LANG['controlpanel']['installsoftcheck']      = "Sono sicuro circa i cambiamenti";
$LANG['controlpanel']['installsoftconfirm']    = "Quando un software ha luogo deinstalled, tutte le configurazioni ed il soddisfare sarete rimossi, siete sicuri?";
$LANG['controlpanel']['installsoftcheckerror'] = "Dovete contrassegnare la casella di controllo per fare quello.";

# Section: Help
# ------------------------------------------------------------------------------
$LANG['help']['alltitle'] = "Yourpacs :: Aiuto";
$LANG['help']['pagetitle'] = "Yourpacs :: ";

# Section: Verify Account
# ------------------------------------------------------------------------------
$LANG['verifyaccount']['ok']     = "Nome valido";
$LANG['verifyaccount']['error1'] = "Troppo corto";
$LANG['verifyaccount']['error2'] = "Devi inserire solo numeri e lettere";
$LANG['verifyaccount']['error3'] = "Già usato";
$LANG['verifyaccount']['error4'] = "Non valido";
$LANG['verifyaccount']['error5'] = "Codice sbagliato";

# Section: Contact
# ------------------------------------------------------------------------------
$LANG['contact']['title']  = "Contatta Yourpacs";
$LANG['contact']['desc']   = "Se vuoi contattarci, sei pregato di completare e inviare questo formulario.";

$LANG['contact']['email']    = "Email";
$LANG['contact']['message']  = "Messaggio";
$LANG['contact']['error1']   = "Non valido";
$LANG['contact']['error2']   = "Troppo corto";
$LANG['contact']['success']  = "Risponderemo presto al tuo meassaggio. Molte grazie.";
$LANG['contact']['text_new'] = "Se Lei ha qualche dubbio o problema con un po' di software di <b>Yourpacs</b>, non dubiti consultare il nostro <a href='http://wiki.Yourpacs.com'>Wiki</a>.<br/><br/>
								Se la si installa che qualche tema o plugin, e le sue soste di Blog funzionino, Lei ha l'opzione di '<i>Ripristinare</i>' nel pannello di controllo di <b>Yourpacs</b>, questa opzione permetterle di disattivare tutti i plugins e mettere un tema di difetto per risolvere il problema.<br/><br/>";

# Section: Recoverpass
# ------------------------------------------------------------------------------
$LANG['recoverpass']['pagetitle']     = "Yourpacs :: Recupera password";
$LANG['recoverpass']['codenovalid']   = "Il codice per cambiare la password, non è valido.";
$LANG['recoverpass']['codechanged']   = "Il codice per cambiare la password è scaduto.";
$LANG['recoverpass']['notexists']     = "Non esiste";
$LANG['recoverpass']['tooshort']      = "E' troppo corto";
$LANG['recoverpass']['notsame']       = "Non sono uguali";
$LANG['recoverpass']['codeincorrect'] = "Questo non è il codice di iscrizione";
$LANG['recoverpass']['codenotexists'] = "Il codice per cambiare la password, non esiste.";

# Section: Userlist
# ------------------------------------------------------------------------------
$LANG['userlist']['pagetitle'] = "Yourpacs :: Indice di utenti ";
$LANG['userlist']['title']     = "Indice di utenti ";
$LANG['userlist']['desc']      = "Qui potrete vedere un elenco organizzato dai temi degli utenti di <strong>Yourpacs</strong>
								  che hanno scritto <strong>più di una voce nel loro Blog</strong>. Per uscire nell'indice,
								  soltanto dovete cominciare scrivere in il vostro.";
