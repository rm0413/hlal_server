<?php

namespace App\Console\Commands;

use App\Services\AgreementListService;
use App\Services\UserService;
use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;

class DesignerSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'designer:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $user_service;
    public $agreement_list_service;
    public function __construct(AgreementListService $agreement_list_service, UserService $user_service)
    {
        parent::__construct();
        $this->user_service = $user_service;
        $this->agreement_list_service = $agreement_list_service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = $this->agreement_list_service->loadCodeWithDesignerSection();
        $user_email_list = $this->user_service->loadEmailList();
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;
        $mail->Port = 25;
        $mail->Host = "203.127.104.86";
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->From = "fdtp.system@ph.fujitsu.com";
        $mail->SetFrom("fdtp.system@ph.fujitsu.com", 'HINSEI & LSA Agreement List | HLAL');
        $mail->addBCC('reinamae.sorisantos@fujitsu.com'); //for prod
        $mail->addBCC('gerly.hernandez@fujitsu.com');
        if (count($result) >= 1) {
            foreach ($user_email_list as $email_list) {
                $mail->addAddress($email_list['emp_email']);
            }
            $mail->Subject = 'HINSEI & LSA Agreement List | Designer Section Answer';
            $mail->Body    = view('designer_email', compact('result'))->render();
            $mail->send();
        }else{
            return "no data";
        }
    }
}
