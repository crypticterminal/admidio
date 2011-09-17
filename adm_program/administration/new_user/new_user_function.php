<?php
/******************************************************************************
 * Neuen User zuordnen - Funktionen
 *
 * Copyright    : (c) 2004 - 2011 The Admidio Team
 * Homepage     : http://www.admidio.org
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 *
 * mode: 1 - Registrierung einem Benutzer zuordnen, der bereits Mitglied der Orga ist
 *       2 - Registrierung einem Benutzer zuordnen, der noch KEIN Mitglied der Orga ist
 *       3 - Benachrichtigung an den User, dass er nun fuer die aktuelle Orga freigeschaltet wurde
 *       4 - User-Account loeschen
 *       6 - Registrierung muss nicht zugeordnet werden, einfach Logindaten verschicken
 * new_user_id: Id des Logins, das verarbeitet werden soll
 * user_id:     Id des Benutzers, dem das neue Login zugeordnet werden soll
 *
 *****************************************************************************/

require_once('../../system/common.php');
require_once('../../system/login_valid.php');
require_once('../../system/classes/system_mail.php');

// Initialize and check the parameters
$getMode      = admFuncVariableIsValid($_GET, 'mode', 'numeric', null, true);
$getNewUserId = admFuncVariableIsValid($_GET, 'new_user_id', 'numeric', null, true);
$getUserId    = admFuncVariableIsValid($_GET, 'user_id', 'numeric', 0);

// nur Webmaster duerfen User bestaetigen, ansonsten Seite verlassen
if($gCurrentUser->approveUsers() == false)
{
   $gMessage->show($gL10n->get('SYS_NO_RIGHTS'));
}

// pruefen, ob Modul aufgerufen werden darf
if($gPreferences['registration_mode'] == 0)
{
    $gMessage->show($gL10n->get('SYS_MODULE_DISABLED'));
}

// create user objects
$new_user = new User($gDb, $gUserFields, $getNewUserId);

if($getUserId > 0)
{
    $user = new User($gDb, $gUserFields, $getUserId);
}

if($getMode == 1 || $getMode == 2)
{
    // User-Account einem existierenden Mitglied zuordnen

    // Daten kopieren, aber nur, wenn noch keine Logindaten existieren
    if(strlen($user->getValue('usr_login_name')) == 0 && strlen($user->getValue('usr_password')) == 0)
    {
        $user->setValue('EMAIL', $new_user->getValue('EMAIL'));
        $user->setValue('usr_login_name', $new_user->getValue('usr_login_name'));
        $user->setValue('usr_password', $new_user->getValue('usr_password'));
    }

    // zuerst den neuen Usersatz loeschen, dann den alten Updaten,
    // damit kein Duplicate-Key wegen dem Loginnamen entsteht
    $new_user->delete();
    $user->save();
}

if($getMode == 2)
{
    // User existiert bereits, ist aber bisher noch kein Mitglied der aktuellen Orga,
    // deshalb erst einmal Rollen zuordnen und dann spaeter eine Mail schicken
    $_SESSION['navigation']->addUrl($g_root_path.'/adm_program/administration/new_user/new_user_function.php?mode=3&user_id='.$getUserId.'&new_user_id='.$getNewUserId);
    header('Location: '.$g_root_path.'/adm_program/modules/profile/roles.php?user_id='.$getUserId);
    exit();
}

if($getMode == 1 || $getMode == 3)
{
    $gMessage->setForwardUrl($g_root_path.'/adm_program/administration/new_user/new_user.php');

    // nur ausfuehren, wenn E-Mails auch unterstuetzt werden
    if($gPreferences['enable_system_mails'] == 1)
    {
        // Mail an den User schicken, um die Anmeldung bwz. die Zuordnung zur neuen Orga zu bestaetigen
        $sysmail = new SystemMail($gDb);
        $sysmail->addRecipient($user->getValue('EMAIL'), $user->getValue('FIRST_NAME'). ' '. $user->getValue('LAST_NAME'));
        if($sysmail->sendSystemMail('SYSMAIL_REGISTRATION_USER', $user) == true)
        {
            $gMessage->show($gL10n->get('NWU_ASSIGN_LOGIN_EMAIL'));
        }
        else
        {
            $gMessage->show($gL10n->get('SYS_EMAIL_NOT_SEND', $user->getValue('EMAIL')));
        }
    }
    else
    {
        $gMessage->show($gL10n->get('NWU_ASSIGN_LOGIN_SUCCESSFUL'));
    }
}
elseif($getMode == 4)
{
    // Registrierung loeschen    
    // im Forum muss er nicht geloescht werden, da der User erst nach der vollstaendigen 
    // Registrierung im Forum angelegt wird.
    $new_user->delete();

    // Loeschen erfolgreich -> Rueckgabe fuer XMLHttpRequest
    echo 'done';
}
elseif($getMode == 6)
{
    // Der User existiert schon und besitzt auch ein Login
    
    // Registrierung loeschen
    // im Forum muss er nicht geloescht werden, da der User erst nach der vollstaendigen 
    // Registrierung im Forum angelegt wird.
    $new_user->delete();

    // Zugangsdaten neu verschicken
    $_SESSION['navigation']->addUrl($g_root_path.'/adm_program/administration/new_user/new_user.php');
    header('Location: '.$g_root_path.'/adm_program/administration/members/members_function.php?mode=4&usr_id='.$getUserId);
    exit();
}

?>