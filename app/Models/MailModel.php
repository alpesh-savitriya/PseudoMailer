<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 1/3/19
 * Time: 2:24 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailModel extends Model
{
    use SoftDeletes;
    protected $table = 'mails';

    protected $fillable = ['mail_from', 'mail_to', 'subject', 'uuid', 'status', 'created_date', 'sent_at', 'opened_at', 'template', 'created_at', 'updated_at', ''];

    public static function listMail() {
        $list = MailModel::get();
        if (isset($list)) {
            return $list;
        }
    }
}