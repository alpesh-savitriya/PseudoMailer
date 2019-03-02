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

    public function sentMails(Request $request) {
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

    public function showMailDetail(Request $request) {
        $response = array();
        $result = array();

//        $id = $request->has('id') ? $request->input('id') : '';
        $uuid = $request->has('uuid') ? $request->input('uuid') : '';

        if ($uuid != '') {
            $listUUID = MailModel::select('*')
                ->where('mails.uuid', '=', $uuid)
                ->get();
            $uuidArray = array();
            $uuidArray['mail_form'] = $listUUID[0]->mail_from;
//            $uuidArray['mail_to'] = $uuidData[0]->mail_to;
            $uuidArray['subject'] = $listUUID[0]->subject;
//            $uuidArray['attachements'] = $uuidData[0]->attachements;
            $uuidArray['uuid'] = $listUUID[0]->uuid;
            $uuidArray['status'] = $listUUID[0]->status;
            $uuidArray['created_date'] = $listUUID[0]->created_date;
            $uuidArray['sent_at'] = $listUUID[0]->sent_at;
            $uuidArray['opened_at'] = $listUUID[0]->opened_at;
            $uuidArray['template'] = $listUUID[0]->template;
            $uuidArray['id'] = array();
            $uuidArray['mail_to'] = array();
            $uuidArray['attachements'] = array();


            foreach ($listUUID as $id) {
                $idArr = array();
                $idArr['id'] = $id->id;
                array_push($uuidArray['id'], $idArr['id']);
            }
            foreach ($listUUID as $mailTo) {
                $mailToArr = array();
                $mailToArr['mail_to'] = $mailTo->mail_to;
                array_push($uuidArray['mail_to'], $mailToArr['mail_to']);
            }
            foreach ($listUUID as $attechement) {
                $attechementArr = array();
                $attechementArr['attachements'] = $attechement->attachements;
                array_push($uuidArray['attachements'], $attechementArr['attachements']);
            }
            array_push($result, $uuidArray);
        }

        if (isset($result)) {
            $response['code'] = 200;
            $response['message'] = 'success';
            $response['content'] = $result;
        } else {
            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = '';
        }

        return response($response, $response['code'])
            ->header('content_type', 'application/json');
    }

}
