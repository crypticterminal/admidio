<?php
/******************************************************************************
 * RSS - Feed fuer das Gaestebuch
 *
 * Copyright    : (c) 2004 - 2011 The Admidio Team
 * Homepage     : http://www.admidio.org
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Erzeugt einen RSS 2.0 - Feed mit Hilfe der RSS-Klasse fuer Gaestebucheintraege
 *
 * Spezifikation von RSS 2.0: http://www.feedvalidator.org/docs/rss2.html
 *
 * Parameters:
 *
 * headline  - Ueberschrift fuer den RSS-Feed
 *             (Default) Gaestebuch
 *
 *****************************************************************************/

require_once('../../system/common.php');
require_once('../../system/classes/rss.php');
require_once('../../system/classes/table_guestbook.php');

// Nachschauen ob RSS ueberhaupt aktiviert ist...
if ($gPreferences['enable_rss'] != 1)
{
    $gMessage->setForwardUrl($gHomepage);
    $gMessage->show($gL10n->get('SYS_RSS_DISABLED'));
}

// pruefen ob das Modul ueberhaupt aktiviert ist
if ($gPreferences['enable_guestbook_module'] != 1)
{
    // das Modul ist deaktiviert
    $gMessage->show($gL10n->get('SYS_MODULE_DISABLED'));
}

// Initialize and check the parameters
$get_headline = admFuncVariableIsValid($_GET, 'headline', 'string', $gL10n->get('GBO_GUESTBOOK'));

// die 10 letzten Eintraege aus der DB fischen...
$sql = 'SELECT * FROM '. TBL_GUESTBOOK. '
         WHERE gbo_org_id = '. $gCurrentOrganization->getValue('org_id'). '
         ORDER BY gbo_timestamp_create DESC
         LIMIT 10 ';
$result = $gDb->query($sql);

// ab hier wird der RSS-Feed zusammengestellt

// Ein RSSfeed-Objekt erstellen
$rss = new RSSfeed('http://'. $gCurrentOrganization->getValue('org_homepage'), $gCurrentOrganization->getValue('org_longname'). ' - '.$get_headline,
		$gL10n->get('GBO_LATEST_GUESTBOOK_ENTRIES_OF_ORGA', $gCurrentOrganization->getValue('org_longname')));
$guestbook = new TableGuestbook($gDb);

// Dem RSSfeed-Objekt jetzt die RSSitems zusammenstellen und hinzufuegen
while ($row = $gDb->fetch_object($result))
{
    // ausgelesene Gaestebuchdaten in Guestbook-Objekt schieben
    $guestbook->clear();
    $guestbook->setArray($row);

    // Die Attribute fuer das Item zusammenstellen
    $title = $guestbook->getValue('gbo_name');
    $link  = $g_root_path.'/adm_program/modules/guestbook/guestbook.php?id='. $guestbook->getValue('gbo_id');
    $description = '<b>'.$guestbook->getValue('gbo_name').' schrieb am '. $guestbook->getValue('gbo_timestamp_create').'</b>';

    // Beschreibung und Link zur Homepage ausgeben
    $description = $description. '<br /><br />'. $guestbook->getText('HTML'). 
                   '<br /><br /><a href="'.$link.'">'. $gL10n->get('SYS_LINK_TO', $gCurrentOrganization->getValue('org_homepage')). '</a>';

    $pubDate = date('r', strtotime($guestbook->getValue('gbo_timestamp_create')));


    // Item hinzufuegen
    $rss->addItem($title, $description, $pubDate, $link);
}


// jetzt nur noch den Feed generieren lassen
$rss->buildFeed();

?>