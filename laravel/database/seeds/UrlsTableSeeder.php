<?php

use Illuminate\Database\Seeder;

class UrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('urls')->insert([
            [
                'url' => 'https://www.google.com.br/?gfe_rd=ctrl&ei=9xcNU6uRGYfJ8Qa-moHwAg&gws_rd=cr#q=audima&safe=off'
            ],
            [
                'url' => 'https://symfony.com/blog/'
            ],
            [
                'url' => 'http://listadeemailmarketinggratis.blogspot.com/2013/10/lista-1-6857-e-mails.html'
            ]
        ]);
    }
}
