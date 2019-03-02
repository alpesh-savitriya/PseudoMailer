<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 1/3/19
 * Time: 2:23 PM
 */

namespace App\Http\Controllers;

use App\Models\MailModel;
use Illuminate\Http\Request;
use Validator;


class PseudoMailerController extends Controller
{

    public function insertMails($mailToArray, $mailFrom, $subject, $template, $attachements) {
        $uuid = uniqid();
        $createdDate = date("Y-m-d h:i:s");
        foreach ($mailToArray as $mailTo) {
            // insert into db
            $createMail = new MailModel();
            $createMail->mail_from = $mailFrom;
            $createMail->mail_to = $mailTo;
            $createMail->subject = $subject;
            $createMail->template = $template;
            $createMail->attachements = json_encode($attachements);
            $createMail->created_date = $createdDate;
            $createMail->uuid = $uuid;
            $createMail->save();
        }
        // return nothing
    }

    public function listMail(Request $request) {
        $result = array();
        $response = array();

        $result = MailModel::listMail();

        if (isset($result)) {
            $response['code'] = 200;
            $response['message'] = 'success';
            $response['content'] = $result;
        } else {
            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = 'There is some error in getting list';
        }

        return response($response, $response['code'])
            ->header('content_type', 'application/json');
    }

    public function sentMails(Request $request)
    {
        $response = array();
        $result = array();

        $mailFrom = $request->has('mailFrom') ? $request->input('mailFrom') : '';
        $mailTos = $request->has('mailTo') ? $request->input('mailTo') : '';
        $subject = $request->has('subject') ? $request->input('subject') : '';
        $emailTemplate = $request->has('template') ? $request->input('template') : '';
        $uuid = uniqid();

//        $list = MailModel::get();
//        print_r(json_decode($list));
//        exit();


        foreach ($mailTos as $mailTo) {
            $createMail = new MailModel();
            $createMail->mail_from = $mailFrom;
            $createMail->mail_to = $mailTo;
            $createMail->subject = $subject;
            $createMail->uuid = $uuid;
            $result = $createMail->save();
        }

        if (isset($result)) {
            $response['code'] = 200;
            $response['message'] = 'success';
            $response['content'] = '';
        } else {
            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = '';
        }

        return response($response, $response['code'])
            ->header('content_type', 'application/json');
    }

}
