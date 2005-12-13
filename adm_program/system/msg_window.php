<?php
/******************************************************************************
 * Popup-Window mit Informationen
 *
 * Copyright    : (c) 2004 - 2005 The Admidio Team
 * Homepage     : http://www.admidio.org
 * Module-Owner : Markus Fassbender
 *
 * err_code  - Code fuer die Information, die angezeigt werden soll
 *
 ******************************************************************************
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *****************************************************************************/

require("common.php");
require("session_check.php");

echo "
<!-- (c) 2004 - 2005 The Admidio Team - http://www.admidio.org - Version: ". getVersion(). " -->\n
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
   <title>Hinweis</title>
   <meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">
   <link rel=\"stylesheet\" type=\"text/css\" href=\"$g_root_path/adm_config/main.css\">

   <!--[if gte IE 5.5000]>
   <script language=\"JavaScript\" src=\"$g_root_path/adm_program/system/correct_png.js\"></script>
   <![endif]-->
</head>

<body>
   <div class=\"groupBox\" align=\"left\" style=\"padding: 10px\">";
      switch ($_GET['err_code'])
      {
         case "attachmentgroesse":
            echo "Hier kannst Du die maximal zul&auml;ssige Gr&ouml;&szlig;e der Email-Attachments in Kilobyte definieren.<br /><br />
                  Wenn Du das Verschicken von Attachments komplett unterbinden m&ouml;chtest, solltest Du 0 eintragen.";
            break;

         case "bbcode":
            echo "Die Beschreibung von Terminen und Ank�ndigungen kannst du mit " .
                  "verschiedenen Tags (BBCode) formatieren. Daf�r musst du die hier aufgelisteten " .
                  "Tags um den entsprechenden Text setzen.<br /><br />
                  Beispiele:<br /><br />
                  <table class=\"tableList\" style=\"width: 100%;\" cellpadding=\"5\" cellspacing=\"0\">
                     <tr>
                        <th class=\"tableHeader\" width=\"155\" valign=\"top\">Beispiel</th>
                        <th class=\"tableHeader\" valign=\"top\">BBCode</th>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <b>fett</b> darstellen</td>
                        <td valign=\"top\">Text <b>[b]</b>fett<b>[/b]</b> darstellen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <u>unterstreichen</u></td>
                        <td valign=\"top\">Text <b>[u]</b>unterstreichen<b>[/u]</b></td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <i>kursiv</i> darstellen</td>
                        <td valign=\"top\">Text <b>[i]</b>kursiv<b>[/i]</b> darstellen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <span style=\"color: #ff0000\">rot</span> darstellen</td>
                        <td valign=\"top\">Text <b>[color=red]</b>rot<b>[/color]</b> darstellen<br>" .
                        "   oder <b>[color=#ff0000]</b>rot<b>[/color]</b></td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <span style=\"font-size: 14pt;\">gro�</span> darstellen</td>
                        <td valign=\"top\">Text <b>[big]</b>gro�<b>[/big]</b> darstellen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Text <span style=\"font-size: 8pt;\">klein</span> darstellen</td>
                        <td valign=\"top\">Text <b>[small]</b>klein<b>[/small]</b> darstellen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Einen <a href=\"http://$g_current_organization->homepage\">Link</a> setzen</td>
                        <td valign=\"top\">Einen <b>[url=</b>http://www.beispiel.de<b>]</b>Link<b>[/url]</b> setzen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Eine <a href=\"mailto:webmaster@$g_domain\">Mailadresse</a> angeben</td>
                        <td valign=\"top\">Eine <b>[email=</b>webmaster@demo.de<b>]</b> Mailadresse<b>[/email]</b> angeben</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Ein Bild <img src=\"$g_root_path/adm_program/images/admidio_logo_20.png\"> anzeigen</td>
                        <td valign=\"top\">Eine Bild <b>[img]</b>http://www.beispiel.de/bild.jpg<b>[/img]</b> anzeigen</td>
                     </tr>
                  </table>";
            break;

         case "condition":
            echo "Hier kannst du Bedingungen zu jedem Feld in deiner neuen Liste eingeben.
                  Damit wird die ausgew&auml;hlte Rolle noch einmal nach deinen Bedingungen
                  eingeschr&auml;nkt.<br /><br />
                  Beispiele:<br /><br />
                  <table class=\"tableList\" style=\"width: 95%;\" cellpadding=\"2\" cellspacing=\"0\">
                     <tr>
                        <th class=\"tableHeader\" width=\"75\" valign=\"top\">Feld</th>
                        <th class=\"tableHeader\" width=\"110\" valign=\"top\">Bedingung</th>
                        <th class=\"tableHeader\">Erkl&auml;rung</th>
                     </tr>
                     <tr>
                        <td valign=\"top\">Nachname</td>
                        <td width=\"110\" valign=\"top\"><b>Schmitz</b></td>
                        <td>Sucht alle Benutzer mit dem Nachnamen Schmitz</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Nachname</td>
                        <td width=\"110\" valign=\"top\"><b>Mei*</b></td>
                        <td>Sucht alle Benutzer deren Namen mit Mei anf&auml;ngt</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Geburtstag</td>
                        <td width=\"110\" valign=\"top\"><b>&gt; 01.03.1986</b></td>
                        <td>Sucht alle Benutzer, die nach dem 01.03.1986 geboren wurden</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Ort</td>
                        <td width=\"110\" valign=\"top\"><b>K&ouml;ln oder Bonn</b></td>
                        <td>Sucht alle Benutzer, die aus K&ouml;ln oder Bonn kommen</td>
                     </tr>
                     <tr>
                        <td valign=\"top\">Telefon</td>
                        <td width=\"110\" valign=\"top\"><b>*241*&nbsp;&nbsp;*54</b></td>
                        <td>Sucht alle Benutzer, deren Telefonnummer 241 enth&auml;lt und
                           mit 54 endet</td>
                     </tr>
                  </table>";
            break;

         case "enable_rss":
            echo "Admidio kann RSS-Feeds f&uuml;r Termine und
                 Ank&uuml;ndigungen auf den jeweiligen &Uuml;bersichtsseiten bereitstellen.";
            break;

         case "email":
            echo "Es ist wichtig, dass du eine g&uuml;ltige E-Mail-Adresse angibst.<br />
                  Ohne diese kann die Anmeldung nicht durchgef&uuml;hrt werden.";
            break;

         case "field_locked":
            echo "Felder, die diese Option aktiviert haben, sind <b>nur</b> f&uuml;r Moderatoren
                  sichtbar und k&ouml;nnen auch nur von diesen gepflegt werden.<br /><br />
                  Benutzer, denen keiner moderierenden Rolle zugewiesen wurden,
                  k&ouml;nnen den Inhalt der Felder weder sehen noch bearbeiten.";
            break;

         case "login":
            echo "Normalerweise wirst du aus Sicherheitsgr&uuml;nden nach 30 Minuten, in denen du
                  nichts auf der Homepage gemacht hast, automatisch abgemeldet.<br /><br />
                  Sollte es allerdings &ouml;fters vorkommen, dass du l&auml;ngere Zeit nicht am Computer
                  bist, du dich aber trotzdem nicht jedesmal neu einloggen willst, so kannst
                  du diesen Zeitraum auf maximal 8 Stunden erh&ouml;hen.";
            break;

         case "mail_extern":
            echo "E-Mails werden in der Regel �ber den Webserver verschickt auf dem Admidio eingerichtet
                  ist. Sollte dein Webserver keinen E-Mailversand unterst�tzen, kannst du diese Option
                  aktivieren. Dadurch wird versucht, das lokale E-Mail-Programm des Benutzers zu starten,
                  sobald dieser auf einen E-Mail-Link klickt.<br /><br />
                  Allerdings funktioniert dann die automatische Benachrichtigung bei Neuanmeldungen nicht
                  mehr.";
            break;

         case "nickname":
            echo "Mit diesem Namen kannst du dich sp&auml;ter auf der Homepage anmelden.<br /><br />
                  Damit du ihn dir leicht merken kannst, solltest du deinen Spitznamen oder Vornamen nehmen.
                  Auch Kombinationen, wie zum Beispiel <i>Andi78</i> oder <i>StefanT</i>, sind m&ouml;glich.";
            break;

         case "password":
            echo "Das Passwort wird verschl&uuml;sselt gespeichert.
                  Es ist sp&auml;ter nicht mehr m&ouml;glich dieses nachzuschauen.
                  Aus diesem Grund solltest du es dir gut merken.";
            break;

         case "profil_felder":
            echo "Du kannst beliebig viele neue Felder definieren, die im Profil der einzelnen Benutzer
            angezeigt und von diesen bearbeitet werden k&ouml;nnen.";
            break;

         case "rolle_termine":
            echo "Benutzer der Rollen, die diese Option aktiviert haben,
                  k�nnen eigene Termine anlegen (keine Ank�ndigungen) und diese
                  sp�ter auch bearbeiten oder l�schen.";
            break;

         case "rolle_benutzer":
            echo "Rollen, die diese Option aktiviert haben, haben die Berechtigung
                  Benutzerdaten (au&szlig;er Passw&ouml;rter) und Rollenzugeh&ouml;rigkeiten
                  anderer Mitglieder zu bearbeiten.";
            break;

         case "rolle_locked":
            echo "Rollen, die diese Option aktiviert haben, sind <b>nur</b> f&uuml;r Moderatoren
                  sichtbar. Benutzer, denen keiner moderierenden Rolle zugewiesen wurden,
                  k&ouml;nnen keine E-Mails an diese Rolle schreiben, keine Listen dieser Rolle
                  aufrufen und sehen auch nicht im Profil einer Person, dass diese Mitglied
                  dieser Rolle ist.";
            break;

         case "rolle_logout":
            echo "Besucher der Homepage, die nicht eingeloggt sind, k&ouml;nnen E-Mails an diese Rolle
                  schreiben, die dann automatisch an alle Mitglieder weitergeleitet wird.";
            break;

         case "rolle_login":
            echo "Benutzer, die sich angemeldet haben, k�nnen E-Mails an diese Rolle schreiben, die
                  dann automatisch an alle Mitglieder weitergeleitet wird.";
            break;

         case "rolle_gruppe":
            echo "Rollen, die diese Option aktiviert haben, haben erweiterte Funktionalit&auml;ten.
                  Zu diesen Rollen k&ouml;nnen weitere Daten der Gruppe (Zeitraum, Uhrzeit, Ort)
                  erfasst und jeder Gruppe Gruppenleiter zugeordnet werden.";
            break;

         case "rolle_moderation":
            echo "Benutzer dieser Rolle bekommen erweiterte Rechte. Sie k&ouml;nnen Rollen erstellen,
                  verwalten und anderen Benutzern Rollen zuordnen. Au&szlig;erdem k&ouml;nnen Sie
                  Ank&uuml;ndigungen und Termine erfassen, bearbeiten und l&ouml;schen.";
            break;

         case "rolle_mail":
            echo "Deine E-Mail wird an alle Mitglieder der ausgew&auml;hlten Rolle geschickt, sofern
                  diese ihre E-Mail-Adresse im System hinterlegt haben.<br /><br />
                  Wenn du eingeloggt bist stehen dir weitere Rollen zur Verf&uuml;gung, an die du E-Mails
                  schreiben kannst.";
            break;

         case "termin_global":
            echo "Termine / Ank&uuml;ndigungen, die diese Option aktiviert haben, erscheinen auf den Webseiten
                  folgender Gruppierungen:<br /><b>";

                  // alle Gruppierungen finden, in denen die Orga entweder Mutter oder Tochter ist
                  $sql = "SELECT * FROM ". TBL_ORGANIZATIONS. "
                           WHERE ag_shortname = '$g_organization'
                              OR ag_mother    = '$g_organization'
                           ORDER BY ag_longname ";
                  $result_bg = mysql_query($sql, $g_adm_con);
                  db_error($result_bg, true);

                  $organizations = "";
                  $i             = 0;

                  while($row_bg = mysql_fetch_object($result_bg))
                  {
                     if($i > 0) $organizations = $organizations. ", ";
                     $organizations = $organizations. $row_bg->ag_longname;

                     if($row_bg->ag_shortname == $g_organization
                     && strlen($row_bg->ag_mother) > 0)
                     {
                        // Muttergruppierung noch auflisten
                        $sql = "SELECT ag_longname FROM ". TBL_ORGANIZATIONS. "
                                 WHERE ag_shortname = '$row_bg->ag_mother' ";
                        $result = mysql_query($sql, $g_adm_con);
                        db_error($result, true);
                        $row = mysql_fetch_array($result);
                        $organizations = $organizations. ", ". $row[0];
                     }

                     $i++;
                  }

                  echo "$organizations</b><br /><br />
                  Moderatoren dieser Gruppierungen k&ouml;nnen den Termin / Nachricht dann bearbeiten
                  bzw. die Option zur&uuml;cksetzen.";
            break;

      case "dateiname":
            echo "   Die Datei sollte so benannt sein, dass man vom Namen auf den Inhalt schlie&szlig;en kann.
               Der Dateiname hat Einfluss auf die Anzeigereihenfolge. In einem Ordner in dem z.B. Sitzungsprotokolle
               gespeichert werden, sollten die Dateinamen immer mit dem Datum beginnen (jjjj-mm-tt).";
            break;
      //Fotomodulhifen

      case "photo_up_help":
         echo " <h3>Was ist zu tun?</h3>
         Auf das &bdquo;Durchsuchen&ldquo; Button klicken und die gew&uuml;nschte Bilddatei auf der
         Festplatte ausw&auml;hlen. Den Vorgang ggf. bis zu f&uuml;nfmal wiederholen,
         bis alle Felder gef&uuml;llt sind. Dann auf &bdquo;Bilder Speichern&ldquo; klicken und ein wenig Geduld haben.
         <br>
         <h3>Hinweise:</h3>
         Die Bilder m&uuml;ssen im JPG Format gespeichert sein.
         Die Bilder werden automatisch auf eine Aufl&ouml;sung von 640Pixel der
         l&auml;ngeren Seite skaliert (andere Seite im Verh&auml;ltnis), bevor sie gespeichert werden.
         Der Name der Dateien spielt keine Rolle, da sie automatisch mit fortlaufender
         Nummer benannt werden.
         Da auch bei schnellen Internetanbindungen das Hochladen von gr&ouml;&szlig;eren Dateien einige
         Zeit in Anspruch nehmen kann, empfehlen wir zun&auml;chst alle hoch zu ladenden Bilder in einen
         Sammelordner zu kopieren und diese dann mit einer Bildbearbeitungssoftware auf 640Pixel
         (l&auml;ngere Bildseite) zu skalieren. Die JPG-Qualit&auml;t sollte beim abspeichern auf 100%
         (also keine Komprimierung) gestellt werden.
         Nat&uuml;rlich ist auch das direkte Upload m&ouml;glich.
         ";
         break;

      case "veranst_help":
         echo " <h3>Was ist zu tun?</h3>
         Alle offenen Felder ausf&uuml;llen. Die Felder Veranstaltung und Beginn sind Pflichtfelder.
         Die Felder Ende und Fotografen sind optional. Alle &uuml;brigen Felder werden automatisch ausgef&uuml;llt.
         Danach auf Speichern klicken.
         ";
         break;
            
      case "folder_not_found":
         echo " <h3>Warnung!!!</h3>
			Der zugeh�rige Ordner wurde nicht Gefunden. Sollte er bewusst �ber FTP gel�scht worden sein
			oder nicht mehr die M�glichkeit bestehen ihn wieder herzustellen, bitte
			den Datensatz mit Button in der Bearbeitungsspalte l�schen (<img src=\"$g_root_path/adm_program/images/delete.png\" style=\"vertical-align: top;\">).
			Besuchern der Website ohne Fotoverwaltungsrecht, wird diese Veranstaltung nich mehr angezeigt.";
         break;
      


         default:
            echo "Es ist ein Fehler aufgetreten.";
            break;
      }

   echo "</div>
      <div style=\"padding-top: 10px;\" align=\"center\">
      <button name=\"schliessen\" type=\"button\" value=\"schliessen\" onclick=\"window.close()\">
      <img src=\"$g_root_path/adm_program/images/error.png\" style=\"vertical-align: middle;\" align=\"top\" vspace=\"1\" width=\"16\" height=\"16\" border=\"0\" alt=\"Schlie&szlig;en\">
      &nbsp;Schlie&szlig;en</button>
      </div>
</body>
</html>";
?>