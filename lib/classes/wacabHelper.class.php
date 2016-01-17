<?php
class wacabHelper
{
    public static function getEmail($contact, $all = false)
    {
        $emails = $contact->get('email', 'value');
        if (empty($emails)) {
            return false;
        } else {
            if ($all) {
                return $emails;
            }
            else {
                return reset($emails);
            }
        }
    }
    public static function getAppPath() {
        return wa()->getAppPath(null, 'wacab');
    }
}