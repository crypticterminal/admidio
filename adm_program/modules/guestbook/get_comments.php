<?php
/******************************************************************************
 * Script mit HTML-Code fuer die Kommentare eines Gaestebucheintrages
 *
 * Copyright    : (c) 2004 - 2009 The Admidio Team
 * Homepage     : http://www.admidio.org
 * Module-Owner : Elmar Meuthen
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Uebergaben:
 *
 * cid: Hiermit wird die ID des Gaestebucheintrages uebergeben
 *
 *****************************************************************************/

require_once('../../system/common.php');
require_once('../../system/classes/table_guestbook_comment.php');

$cid = 0;

if (isset($_GET['cid']) && is_numeric($_GET['cid']))
{
    // Script wurde ueber Ajax aufgerufen
    $cid = $_GET['cid'];
}

if ($cid > 0)
{
    $sql    = 'SELECT * FROM '. TBL_GUESTBOOK_COMMENTS. ', '. TBL_GUESTBOOK. '
                WHERE gbo_id     = '.$cid.'
                  AND gbc_gbo_id = gbo_id
                  AND gbo_org_id = '. $g_current_organization->getValue('org_id'). '
                ORDER by gbc_timestamp_create asc';
    $comment_result = $g_db->query($sql);
}

if (isset($comment_result))
{

    echo '<div id="comments_'.$cid.'" style="visibility: visible; display: block; text-align: left;">';

    //Kommentarnummer auf 1 setzen
    $commentNumber = 1;
    $gbComment = new TableGuestbookComment($g_db);

    // Jetzt nur noch die Kommentare auflisten
    while ($row = $g_db->fetch_object($comment_result))
    {
        // GBComment-Objekt initialisieren und neuen DS uebergeben
        $gbComment->clear();
        $gbComment->setArray($row);
    
        $cid = $gbComment->getValue('gbc_gbo_id');

        echo '
        <div class="groupBox" id="gbc_'.$gbComment->getValue('gbc_id').'" style="overflow: hidden; margin-left: 20px; margin-right: 20px;">
            <div class="groupBoxHeadline">
                <div class="boxHeadLeft">
                    <img src="'. THEME_PATH. '/icons/comments.png" style="vertical-align: top;" alt="'.$g_l10n->get('GBO_COMMENT_BY', $gbComment->getValue('gbc_name')).'" />&nbsp;'.
                    $g_l10n->get('GBO_COMMENT_BY', $gbComment->getValue('gbc_name'));

                    // Falls eine Mailadresse des Users angegeben wurde, soll ein Maillink angezeigt werden...
                    if (isValidEmailAddress($gbComment->getValue('gbc_email')))
                    {
                        echo '<a class="iconLink" href="mailto:'.$gbComment->getValue('gbc_email').'"><img src="'. THEME_PATH. '/icons/email.png" 
                            alt="'.$g_l10n->get('SYS_SEND_EMAIL_TO', $gbComment->getValue('gbc_email')).'" title="'.$g_l10n->get('SYS_SEND_EMAIL_TO', $gbComment->getValue('gbc_email')).'" /></a>';
                    }
                echo '
                </div>

                <div class="boxHeadRight">'. $gbComment->getValue('gbc_timestamp_create', $g_preferences['system_date'].' '.$g_preferences['system_time']);

                // aendern und loeschen von Kommentaren duerfen nur User mit den gesetzten Rechten
                if ($g_current_user->editGuestbookRight())
                {
                    echo '
                    <a class="iconLink" href="'.$g_root_path.'/adm_program/modules/guestbook/guestbook_comment_new.php?cid='.$gbComment->getValue('gbc_id').'"><img 
                        src="'. THEME_PATH. '/icons/edit.png" alt="'.$g_l10n->get('SYS_EDIT').'" title="'.$g_l10n->get('SYS_EDIT').'" /></a>
                    <a class="iconLink" href="javascript:deleteObject(\'gbc\', \'gbc_'.$gbComment->getValue('gbc_id').'\','.$gbComment->getValue('gbc_id').',\''.$row->gbc_name.'\')"><img 
                        src="'. THEME_PATH. '/icons/delete.png" alt="'.$g_l10n->get('SYS_DELETE').'" title="'.$g_l10n->get('SYS_DELETE').'" /></a>';
                }

                echo '</div>
            </div>

            <div class="groupBoxBody">'.
                $gbComment->getText('HTML');

                // Falls der Kommentar editiert worden ist, wird dies angezeigt
                if($gbComment->getValue('gbc_usr_id_change') > 0)
                {
                    // Userdaten des Editors holen...
                    $user_change = new User($g_db, $gbComment->getValue('gbc_usr_id_change'));

                    echo '
                    <div class="editInformation">'.
                        $g_l10n->get('SYS_PHR_LAST_EDITED_BY', $user_change->getValue('FIRST_NAME'). ' '. $user_change->getValue('LAST_NAME'), $gbComment->getValue('gbc_timestamp_change')). '
                    </div>';
                }
            echo '
            </div>
        </div>

        <br />';

        // Kommentarnummer um 1 erhoehen
        $commentNumber = $commentNumber + 1;

    }

    if ($g_current_user->commentGuestbookRight() || $g_preferences['enable_gbook_comments4all'] == 1)
    {
        // Bei Kommentierungsrechten, wird der Link zur Kommentarseite angezeigt...
        $load_url = $g_root_path.'/adm_program/modules/guestbook/guestbook_comment_new.php?id='.$cid.'';
        echo '
        <div class="editInformation">
            <span class="iconTextLink">
                <a href="'.$load_url.'"><img src="'. THEME_PATH. '/icons/comment_new.png" 
                alt="'.$g_l10n->get('GBO_PHR_WRITE_COMMENT').'" title="'.$g_l10n->get('GBO_PHR_WRITE_COMMENT').'" /></a>
                <a href="'.$load_url.'">'.$g_l10n->get('GBO_PHR_WRITE_COMMENT').'</a>
            </span>
        </div>';
    }

    echo'
    </div>';
}

?>