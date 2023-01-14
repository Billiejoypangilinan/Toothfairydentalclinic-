<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mail;

use App\Models\{
    CaseNotification
};

class SendEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sendiing email to all cases with dues';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $date_now     = date('Y-m-d');
        $one_day      = date('Y-m-d', strtotime($date_now.' + 1 days'));
        $two_days     = date('Y-m-d', strtotime($date_now.' + 2 days'));
        $three_days   = date('Y-m-d', strtotime($date_now.' + 3 days'));
        $seven_days   = date('Y-m-d', strtotime($date_now.' + 7 days'));
        

        $dates = [$date_now, $one_day, $two_days, $three_days, $seven_days];

        $cases = DB::table('cases as c')
                ->selectRaw('c.id, c.case_type, c.case_no, s.name AS step, h.name AS handler_name, h.email, cs.completion_date, ag.duration, cs.id as case_step_id')
                ->join('case_step as cs', function($cases){
                    $cases->whereRaw('cs.step_id = c.step_id')
                          ->whereRaw('cs.case_id = c.id');
                })
                ->join('handlers as h', 'h.id', 'c.handler_id')
                ->join('steps as s', 's.id', 'c.step_id')
                ->join('aging as ag', 'ag.step_id', 'c.step_id')
                ->whereIn('cs.completion_date', $dates)
                ->where('c.status', 1)
                ->get();

        $response         = [];
        $seven_three_one  = [7,3,1];
        $three_two_one    = [3,2,1];

        if($cases){
            foreach($cases as $d){
                $case_id        = $d->id;
                $case_step_id   = $d->case_step_id;
                $case_no        = $d->case_no;
                $duration       = $d->duration;
                $case_type      = $d->case_type;
                $handler        = $d->handler_name;
                $email          = $d->email; 
                $step           = $d->step;
                $due_date       = date('Y-m-d', strtotime($d->completion_date)); 
                $days           = dateDiffInDays($date_now, $due_date);

                if($duration > 5){
                    if(in_array($days, $seven_three_one)){
                        $to_name  = $handler;
                        $to_email = $email;

                        $data = [
                            'case_type' => $case_type,
                            'case_no'   => $case_no,
                            'step'      => $step,
                            'due_date'  => date('F d, Y  - l', strtotime($due_date)),
                            'handler'   => $handler
                        ];  

                        $email_subject = 'NOTIFICATION FOR CASE '.$case_no;

                        Mail::send('emails.handler_notif_template', $data, function($message) use ($to_name, $to_email, $email_subject) {
                            $message->to($to_email, $to_name)
                            ->subject($email_subject);
                            $message->from('noreply.hsac@gmail.com', 'HSAC Admin');
                        });

                        if (Mail::failures()) {
                            array_push($response, [
                                'case_id'       => $case_id,
                                'case_step_id'  => $case_step_id,
                                'case_no'       => $case_no,
                                'email_stat'    => 'Failed'
                            ]);
                            info($response);
                        }else{
                            //$stat = 'Sent';
                            CaseNotification::firstOrCreate([
                                'case_id' => $case_id,
                                'step_id' => $case_step_id
                            ],[
                                'date_notified' => date('Y-m-d')
                            ]);
                        }
                    }
                }

                if($duration <= 5){

                    if(in_array($days, $three_two_one)){
                        $to_name  = $handler;
                        $to_email = $email;

                        $data = [
                            'case_type' => $case_type,
                            'case_no'   => $case_no,
                            'step'      => $step,
                            'due_date'  => date('F d, Y  - l', strtotime($due_date)),
                            'handler'   => $handler
                        ];  

                        $email_subject = 'NOTIFICATION FOR CASE '.$case_no;

                        Mail::send('emails.handler_notif_template', $data, function($message) use ($to_name, $to_email, $email_subject) {
                            $message->to($to_email, $to_name)
                            ->subject($email_subject);
                            $message->from('noreply.hsac@gmail.com', 'HSAC Admin');
                        });

                        if (Mail::failures()) {
                            array_push($response, [
                                'case_id'       => $case_id,
                                'case_step_id'  => $case_step_id,
                                'case_no'       => $case_no,
                                'email_stat'    => 'Failed'
                            ]);

                            info($response);
                        }else{
                            CaseNotification::firstOrCreate([
                                'case_id' => $case_id,
                                'step_id' => $case_step_id
                            ],[
                                'date_notified' => date('Y-m-d')
                            ]);
                        }

                    }
                }
                
            }
        }
        
        
        
    }
}
