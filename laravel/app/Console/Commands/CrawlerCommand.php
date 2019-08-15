<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use DB;

class CrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:start';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->crawlerInit()){
            echo "Terminou com sucesso!\n";
        }else{
            echo "Ocorreu um erro!\n";
        }
    }

    protected function crawlerInit(){
        $client = new Client();
        $urls = DB::table('urls')->where('visited','no')->pluck('url','id')->toArray(); # Urls não visitadas
        $allUrls =  DB::table('urls')->pluck('url','id')->toArray(); # Todas urls para verificação
        $emailsDb = DB::table('emails')->pluck('email','id')->toArray(); # Todos emails para verificação
        $allLink = []; # Armazena os links que passarem pela validação
        $allEmail =[]; # Armazena os emails que passarem pela validação
        foreach($urls as $url){
            try{
                $crawler = $client->request('GET', $url);
                $html = $crawler->html();
                $links = [];
                $emails = [];
                preg_match_all('/<a href=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?>/i', $html, $links);
                preg_match_all('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $html, $emails);
                if(isset($links[1])){
                    foreach(array_unique($links[1]) as $l){ 
                        if(!in_array($l, $allUrls) and strpos($l, 'http') !== false){
                            $allLink[] = ['url' => $l];
                        }
                    }
                }
                if(isset($emails[0])){
                    foreach(array_unique($emails[0]) as $em){
                        if(!in_array($em, $emailsDb)){
                            $allEmail[] = ['email' => $em];
                        }
                    }
                }
            }catch(\Throwable $t){
                echo "Erro na requisição da url: ".$url."\n";
            }
        }
        return $this->crawlerSave($urls, $allLink, $allEmail);
    }

    public function crawlerSave($urls, $links, $emails){
        $status = false;
        DB::transaction(function () use (&$status, $urls, $links, $emails) {
            DB::table('urls')->insert($links);
            DB::table('emails')->insert($emails);
            DB::table('urls')->whereIn('url', $urls)->update(['visited' => 'yes']);
            $status = true;
        });
        return $status;
    }
}
